<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Referral;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('client.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'timezone' => 'nullable|string|max:50',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::log('password_changed', 'Password updated');

        return back()->with('success', 'Password updated successfully.');
    }

    public function referrals()
    {
        $user = auth()->user();

        // Ensure user has a referral code entry
        $referral = Referral::firstOrCreate(
            ['referrer_id' => $user->id, 'referred_id' => null],
            [
                'code' => strtoupper(Str::random(8)),
            ]
        );

        // Load all conversion entries for this referral code
        $conversions = Referral::where('referrer_id', $user->id)
            ->whereNotNull('referred_id')
            ->with('referred')
            ->latest()
            ->take(20)
            ->get();

        $referral->conversions = $conversions;

        return view('client.referrals', compact('referral'));
    }

    public function enable2FA(Request $request)
    {
        $user = auth()->user();

        // Generate a simple TOTP secret (Base32-encoded)
        $secret = strtoupper(Str::random(16));
        $recoveryCodes = collect(range(1, 8))->map(fn() => strtoupper(Str::random(10)))->toArray();

        $user->update([
            'two_factor_enabled' => true,
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ]);

        ActivityLog::log('2fa_enabled', 'Two-factor authentication enabled');

        return back()->with('success', 'Two-factor authentication has been enabled. Save your recovery codes: ' . implode(', ', $recoveryCodes));
    }

    public function disable2FA(Request $request)
    {
        $request->validate(['password' => 'required']);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        auth()->user()->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ]);

        ActivityLog::log('2fa_disabled', 'Two-factor authentication disabled');

        return back()->with('success', 'Two-factor authentication disabled.');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('user_id', auth()->id())->latest()->get();
        return view('client.testimonials', compact('testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:20|max:2000',
            'rating' => 'required|integer|min:1|max:5',
            'position' => 'nullable|string|max:100',
        ]);

        Testimonial::create([
            'user_id' => auth()->id(),
            'client_name' => auth()->user()->name,
            'client_position' => $request->input('position'),
            'client_company' => auth()->user()->company,
            'client_avatar' => auth()->user()->avatar,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_active' => true,
            'status' => 'pending',
        ]);

        ActivityLog::log('testimonial_submitted', 'Client submitted a testimonial for review');

        return back()->with('success', 'Thank you! Your review has been submitted and is pending approval.');
    }
}
