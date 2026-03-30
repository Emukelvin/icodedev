<?php

namespace App\Rules;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $settings = Setting::getAllCached();

        if (($settings['recaptcha_enabled'] ?? '0') !== '1') {
            return; // reCAPTCHA disabled — skip validation
        }

        $secretKey = config('services.recaptcha.secret_key');

        if (empty($secretKey)) {
            Log::warning('reCAPTCHA enabled but RECAPTCHA_SECRET_KEY is missing from .env');
            return; // Misconfigured — don't block users
        }

        if (empty($value)) {
            $fail('Please complete the reCAPTCHA verification.');
            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!($result['success'] ?? false)) {
                Log::info('reCAPTCHA verification failed', [
                    'error-codes' => $result['error-codes'] ?? [],
                ]);
                $fail('reCAPTCHA verification failed. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error: ' . $e->getMessage());
            // Don't block users on network errors
        }
    }

    /**
     * Check if reCAPTCHA is currently enabled.
     */
    public static function isEnabled(): bool
    {
        $settings = Setting::getAllCached();
        return ($settings['recaptcha_enabled'] ?? '0') === '1'
            && !empty(config('services.recaptcha.site_key'));
    }

    /**
     * Get the site key for use in Blade templates.
     */
    public static function siteKey(): string
    {
        return config('services.recaptcha.site_key', '');
    }
}
