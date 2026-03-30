@php
    $s = \App\Models\Setting::getAllCached();
    $siteName = $s['site_name'] ?? 'ICodeDev';
    $tagline = $s['site_tagline'] ?? 'Technology Solutions';
    $emailLogo = !empty($s['email_logo']) ? asset($s['email_logo']) : (!empty($s['logo_url']) ? asset($s['logo_url']) : '');
    $primaryColor = '#6366f1';
    $siteUrl = config('app.url');
    $contactEmail = $s['contact_email'] ?? config('mail.from.address');
    $contactPhone = $s['contact_phone'] ?? '';
    $address = $s['contact_address'] ?? '';
    $copyright = $s['copyright_text'] ?? '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.';
    $socialFacebook = $s['social_facebook'] ?? '';
    $socialTwitter = $s['social_twitter'] ?? '';
    $socialInstagram = $s['social_instagram'] ?? '';
    $socialLinkedin = $s['social_linkedin'] ?? '';
@endphp
<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta charset="utf-8">
<meta name="x-apple-disable-message-reformatting">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
<!--[if mso]><noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript><style>td,th,div,p,a,h1,h2,h3,h4,h5,h6{font-family:"Segoe UI",sans-serif;mso-line-height-rule:exactly;}</style><![endif]-->
<title>{{ $subject ?? $siteName }}</title>
<style>
    :root { color-scheme: light; }
    * { margin: 0; padding: 0; }
    body, table, td { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
    body { background-color: #0f0f14; color: #e2e8f0; width: 100%; -webkit-text-size-adjust: 100%; }
    img { display: block; border: 0; outline: 0; text-decoration: none; -ms-interpolation-mode: bicubic; max-width: 100%; }
    a { color: {{ $primaryColor }}; text-decoration: none; }
    .btn { display: inline-block; padding: 14px 32px; background: {{ $primaryColor }}; color: #ffffff !important; border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none; text-align: center; letter-spacing: 0.3px; }
    .btn:hover { background: #4f46e5; }
    @media only screen and (max-width: 620px) {
        .container { width: 100% !important; padding: 0 16px !important; }
        .content { padding: 28px 20px !important; }
        .header { padding: 24px 20px !important; }
        .footer { padding: 24px 20px !important; }
        .hero-icon { width: 56px !important; height: 56px !important; }
        h1 { font-size: 22px !important; }
        .btn { padding: 12px 24px !important; font-size: 13px !important; }
    }
</style>
</head>
<body style="background-color: #0f0f14; margin: 0; padding: 0;">

<!-- Preheader -->
<div style="display: none; max-height: 0px; overflow: hidden;">{{ $preheader ?? '' }}&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #0f0f14;">
<tr><td align="center" style="padding: 24px 16px 40px;">

    <!-- Main Container -->
    <table role="presentation" class="container" width="580" cellpadding="0" cellspacing="0" style="max-width: 580px; width: 100%;">

        <!-- Header -->
        <tr>
            <td class="header" align="center" style="padding: 32px 40px 24px;">
                @if($emailLogo)
                <img src="{{ $emailLogo }}" alt="{{ $siteName }}" height="44" style="height: 44px; width: auto; max-width: 200px;">
                @else
                <div style="font-size: 26px; font-weight: 800; color: {{ $primaryColor }}; letter-spacing: -0.5px;">{{ $siteName }}</div>
                @endif
            </td>
        </tr>

        <!-- Card Body -->
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #1a1a24; border-radius: 16px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden;">

                    <!-- Icon + Title Banner -->
                    @isset($icon)
                    <tr>
                        <td style="background: linear-gradient(135deg, {{ $primaryColor }}12, {{ $primaryColor }}06); padding: 32px 40px 24px; border-bottom: 1px solid rgba(255,255,255,0.04);" class="content">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-right: 16px; vertical-align: top;">
                                        <div class="hero-icon" style="width: 48px; height: 48px; border-radius: 14px; background: {{ $iconBg ?? $primaryColor }}20; text-align: center; line-height: 48px; font-size: 22px;">
                                            {{ $icon }}
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 0; line-height: 1.3;">{{ $title ?? '' }}</h1>
                                        @isset($subtitle)
                                        <p style="font-size: 13px; color: rgba(255,255,255,0.45); margin-top: 4px;">{{ $subtitle }}</p>
                                        @endisset
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endisset

                    <!-- Main Content -->
                    <tr>
                        <td class="content" style="padding: 36px 40px;">
                            @isset($greeting)
                            <p style="font-size: 16px; color: #ffffff; font-weight: 600; margin-bottom: 20px;">{{ $greeting }}</p>
                            @endisset

                            @yield('content')

                            <!-- Action Button -->
                            @isset($actionUrl)
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 32px 0 12px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $actionUrl }}" class="btn" style="display: inline-block; padding: 14px 36px; background: {{ $primaryColor }}; color: #ffffff !important; border-radius: 10px; font-weight: 700; font-size: 14px; text-decoration: none;">{{ $actionText ?? 'View Details' }}</a>
                                    </td>
                                </tr>
                            </table>
                            @endisset
                        </td>
                    </tr>

                    <!-- Info Cards Slot -->
                    @hasSection('cards')
                    <tr>
                        <td style="padding: 0 40px 32px;" class="content">
                            @yield('cards')
                        </td>
                    </tr>
                    @endif

                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td class="footer" style="padding: 32px 40px 16px;">
                <!-- Social Icons -->
                @if($socialFacebook || $socialTwitter || $socialInstagram || $socialLinkedin)
                <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin-bottom: 20px;">
                    <tr>
                        @if($socialFacebook)
                        <td style="padding: 0 6px;"><a href="{{ $socialFacebook }}" style="display: inline-block; width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.06); text-align: center; line-height: 32px; font-size: 14px; color: rgba(255,255,255,0.4);">f</a></td>
                        @endif
                        @if($socialTwitter)
                        <td style="padding: 0 6px;"><a href="{{ $socialTwitter }}" style="display: inline-block; width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.06); text-align: center; line-height: 32px; font-size: 14px; color: rgba(255,255,255,0.4);">𝕏</a></td>
                        @endif
                        @if($socialInstagram)
                        <td style="padding: 0 6px;"><a href="{{ $socialInstagram }}" style="display: inline-block; width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.06); text-align: center; line-height: 32px; font-size: 14px; color: rgba(255,255,255,0.4);">ig</a></td>
                        @endif
                        @if($socialLinkedin)
                        <td style="padding: 0 6px;"><a href="{{ $socialLinkedin }}" style="display: inline-block; width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.06); text-align: center; line-height: 32px; font-size: 14px; color: rgba(255,255,255,0.4);">in</a></td>
                        @endif
                    </tr>
                </table>
                @endif

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="font-size: 12px; color: rgba(255,255,255,0.25); line-height: 1.6;">
                            <p style="margin-bottom: 6px;"><a href="{{ $siteUrl }}" style="color: rgba(255,255,255,0.4); font-weight: 600;">{{ $siteName }}</a>@if($tagline) — {{ $tagline }}@endif</p>
                            @if($address)<p style="margin-bottom: 6px;">{{ $address }}</p>@endif
                            @if($contactEmail)<p style="margin-bottom: 6px;"><a href="mailto:{{ $contactEmail }}" style="color: {{ $primaryColor }};">{{ $contactEmail }}</a>@if($contactPhone) &bull; {{ $contactPhone }}@endif</p>@endif
                            <p style="margin-top: 12px; padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.04);">{{ $copyright }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

</td></tr>
</table>

</body>
</html>
