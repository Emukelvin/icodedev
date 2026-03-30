@if(App\Rules\Recaptcha::isEnabled())
<div class="space-y-1">
    <div class="g-recaptcha" data-sitekey="{{ App\Rules\Recaptcha::siteKey() }}" data-theme="dark"></div>
    @error('g-recaptcha-response')
    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
    @enderror
</div>
@endif
