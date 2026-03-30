<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use App\Notifications\WelcomeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Rules\Recaptcha;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            ActivityLog::log('login', 'User logged in', $user);

            // Check if 2FA is enabled
            if ($user->two_factor_enabled) {
                session(['2fa_pending' => true]);
                return redirect()->route('2fa.challenge');
            }

            return redirect()->intended($this->redirectPath($user));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Honeypot anti-spam
        if ($request->filled('website_url')) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'g-recaptcha-response' => [new Recaptcha],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'client',
        ]);

        ActivityLog::log('register', 'New user registered', $user);

        try {
            $user->notify(new WelcomeUser);
        } catch (\Throwable $e) {
            report($e);
        }

        Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'Welcome to ICodeDev! Your account has been created.');
    }

    public function logout(Request $request)
    {
        ActivityLog::log('logout', 'User logged out');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    protected function redirectPath(User $user): string
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard'),
            'manager' => route('admin.dashboard'),
            'developer' => route('developer.dashboard'),
            default => route('client.dashboard'),
        };
    }

    public function show2FAChallenge()
    {
        if (!auth()->user()->two_factor_enabled) {
            return redirect($this->redirectPath(auth()->user()));
        }

        return view('auth.2fa-challenge');
    }

    public function verify2FA(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = auth()->user();

        if (! $user->two_factor_enabled || ! $user->two_factor_secret) {
            return back()->with('error', '2FA is not enabled on your account.');
        }

        $secret = decrypt($user->two_factor_secret);
        $validWindow = 1; // Allow 30 seconds before/after

        // TOTP verification: generate expected code and compare
        $timeSlice = floor(time() / 30);
        $valid = false;

        for ($i = -$validWindow; $i <= $validWindow; $i++) {
            $expectedCode = $this->generateTOTPCode($secret, $timeSlice + $i);
            if (hash_equals($expectedCode, $request->code)) {
                $valid = true;
                break;
            }
        }

        if (! $valid) {
            // Check recovery codes
            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true) ?? [];
            $codeIndex = array_search($request->code, $recoveryCodes);

            if ($codeIndex !== false) {
                unset($recoveryCodes[$codeIndex]);
                $user->update([
                    'two_factor_recovery_codes' => encrypt(json_encode(array_values($recoveryCodes))),
                ]);
                $valid = true;
            }
        }

        if ($valid) {
            session(['2fa_verified' => true]);
            return redirect()->intended($this->redirectPath($user));
        }

        return back()->withErrors(['code' => 'Invalid verification code.']);
    }

    protected function generateTOTPCode(string $secret, int $timeSlice): string
    {
        $secretKey = base_convert($secret, 32, 16);
        $time = pack('N*', 0, $timeSlice);
        $hash = hash_hmac('sha1', $time, hex2bin($secretKey), true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $code = (
            ((ord($hash[$offset]) & 0x7f) << 24) |
            ((ord($hash[$offset + 1]) & 0xff) << 16) |
            ((ord($hash[$offset + 2]) & 0xff) << 8) |
            (ord($hash[$offset + 3]) & 0xff)
        ) % 1000000;

        return str_pad((string) $code, 6, '0', STR_PAD_LEFT);
    }
}
