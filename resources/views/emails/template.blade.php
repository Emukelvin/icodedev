@php
    $s = \App\Models\Setting::getAllCached();
    $siteName = $s['site_name'] ?? 'ICodeDev';
    $tagline = $s['site_tagline'] ?? 'Technology Solutions';
    $logoPath = !empty($s['email_logo']) ? $s['email_logo'] : (!empty($s['logo_url']) ? $s['logo_url'] : '');
    $emailLogo = '';
    if ($logoPath) {
        $fullPath = public_path(ltrim($logoPath, '/'));
        if (file_exists($fullPath)) {
            $mime = mime_content_type($fullPath);
            $emailLogo = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
        } else {
            $emailLogo = asset($logoPath);
        }
    }
    $primaryColor = '#6366f1';
    $primaryDark = '#4f46e5';
    $accentGlow = '#818cf8';
    $siteUrl = config('app.url');
    $contactEmail = $s['contact_email'] ?? config('mail.from.address');
    $contactPhone = $s['contact_phone'] ?? '';
    $address = $s['contact_address'] ?? '';
    $copyright = $s['copyright_text'] ?? '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.';
    $socialFacebook = $s['social_facebook'] ?? '';
    $socialTwitter = $s['social_twitter'] ?? '';
    $socialInstagram = $s['social_instagram'] ?? '';
    $socialLinkedin = $s['social_linkedin'] ?? '';
    $socialGithub = $s['social_github'] ?? '';
    $currentYear = date('Y');
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
    :root { color-scheme: light dark; supported-color-schemes: light dark; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body, table, td { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
    body { background-color: #0a0a10; color: #e2e8f0; width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    img { display: block; border: 0; outline: 0; text-decoration: none; -ms-interpolation-mode: bicubic; max-width: 100%; }
    a { color: {{ $accentGlow }}; text-decoration: none; transition: color 0.2s; }
    a:hover { color: #a5b4fc; }
    .btn { display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, {{ $primaryColor }}, {{ $primaryDark }}); color: #ffffff !important; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none; text-align: center; letter-spacing: 0.4px; mso-padding-alt: 16px 40px 16px 40px; }
    .btn:hover { background: linear-gradient(135deg, {{ $accentGlow }}, {{ $primaryColor }}); }
    @media only screen and (max-width: 620px) {
        .container { width: 100% !important; padding: 0 12px !important; }
        .content { padding: 24px 20px !important; }
        .header { padding: 20px 20px !important; }
        .footer { padding: 24px 20px !important; }
        .hero-icon { width: 52px !important; height: 52px !important; }
        h1 { font-size: 20px !important; }
        .btn { padding: 14px 28px !important; font-size: 13px !important; }
        .accent-bar td { height: 3px !important; }
        .social-icon { width: 36px !important; height: 36px !important; line-height: 36px !important; }
    }
</style>
</head>
<body style="background-color: #0a0a10; margin: 0; padding: 0;">

<!-- Preheader (hidden accessible text) -->
<div style="display: none; max-height: 0px; overflow: hidden; mso-hide: all;">{{ $preheader ?? '' }}&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #0a0a10;">
<tr><td align="center" style="padding: 32px 16px 48px;">

    <!-- Main Container -->
    <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%;">

        <!-- Gradient Accent Bar -->
        <tr>
            <td>
                <table role="presentation" class="accent-bar" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height: 4px; background: linear-gradient(90deg, {{ $primaryColor }}, {{ $accentGlow }}, #a78bfa, {{ $primaryColor }}); border-radius: 4px 4px 0 0; font-size: 0; line-height: 0;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Header -->
        <tr>
            <td style="background-color: #111118; border-left: 1px solid rgba(255,255,255,0.04); border-right: 1px solid rgba(255,255,255,0.04);">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="header" align="center" style="padding: 28px 40px 24px;">
                            @if($emailLogo)
                            <img src="{{ $emailLogo }}" alt="{{ $siteName }}" height="40" style="height: 40px; width: auto; max-width: 180px;">
                            @else
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-right: 10px; vertical-align: middle;">
                                        <div style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, {{ $primaryColor }}, {{ $primaryDark }}); text-align: center; line-height: 36px; font-size: 18px; font-weight: 800; color: #fff;">&lt;/&gt;</div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div style="font-size: 22px; font-weight: 800; color: #ffffff; letter-spacing: -0.5px;">{{ $siteName }}</div>
                                    </td>
                                </tr>
                            </table>
                            @endif
                        </td>
                    </tr>
                    <!-- Subtle divider -->
                    <tr>
                        <td style="padding: 0 40px;">
                            <div style="height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Card Body -->
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #13131b; border-left: 1px solid rgba(255,255,255,0.04); border-right: 1px solid rgba(255,255,255,0.04);">

                    <!-- Icon + Title Banner -->
                    @isset($icon)
                    <tr>
                        <td style="background: linear-gradient(180deg, #111118, #13131b); padding: 36px 40px 28px; border-bottom: 1px solid rgba(255,255,255,0.04);" class="content">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding-right: 18px; vertical-align: top; width: 56px;">
                                        <div class="hero-icon" style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, {{ $iconBg ?? $primaryColor }}18, {{ $iconBg ?? $primaryColor }}08); border: 1px solid {{ $iconBg ?? $primaryColor }}20; text-align: center; line-height: 56px; font-size: 26px;">
                                            {{ $icon }}
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 0; line-height: 1.25; letter-spacing: -0.3px;">{{ $title ?? '' }}</h1>
                                        @isset($subtitle)
                                        <p style="font-size: 13px; color: rgba(255,255,255,0.4); margin-top: 6px; line-height: 1.4;">{{ $subtitle }}</p>
                                        @endisset
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endisset

                    <!-- Main Content -->
                    <tr>
                        <td class="content" style="padding: 36px 40px 32px;">
                            @isset($greeting)
                            <p style="font-size: 16px; color: #ffffff; font-weight: 600; margin-bottom: 20px; line-height: 1.5;">{{ $greeting }}</p>
                            @endisset

                            @yield('content')

                            <!-- Action Button -->
                            @isset($actionUrl)
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 32px 0 8px;">
                                <tr>
                                    <td align="center">
                                        <!--[if mso]>
                                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="{{ $actionUrl }}" style="height:48px;v-text-anchor:middle;width:220px;" arcsize="25%" strokecolor="{{ $primaryDark }}" fillcolor="{{ $primaryColor }}">
                                        <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">{{ $actionText ?? 'View Details' }}</center>
                                        </v:roundrect>
                                        <![endif]-->
                                        <!--[if !mso]><!-->
                                        <a href="{{ $actionUrl }}" class="btn" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, {{ $primaryColor }}, {{ $primaryDark }}); color: #ffffff !important; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none; letter-spacing: 0.4px; box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3), 0 2px 4px rgba(0,0,0,0.2);">{{ $actionText ?? 'View Details' }} →</a>
                                        <!--<![endif]-->
                                    </td>
                                </tr>
                            </table>
                            @endisset
                        </td>
                    </tr>

                    <!-- Info Cards Slot -->
                    @hasSection('cards')
                    <tr>
                        <td style="padding: 0 40px 36px;" class="content">
                            @yield('cards')
                        </td>
                    </tr>
                    @endif

                </table>
            </td>
        </tr>

        <!-- Footer Divider -->
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #111118; border-left: 1px solid rgba(255,255,255,0.04); border-right: 1px solid rgba(255,255,255,0.04);">
                    <tr>
                        <td style="padding: 0 40px;">
                            <div style="height: 1px; background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.2), transparent);"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #0e0e15; border-left: 1px solid rgba(255,255,255,0.04); border-right: 1px solid rgba(255,255,255,0.04); border-radius: 0 0 16px 16px; border-bottom: 1px solid rgba(255,255,255,0.04);">
                    <tr>
                        <td class="footer" style="padding: 32px 40px 28px;">

                            <!-- Social Icons -->
                            @if($socialFacebook || $socialTwitter || $socialInstagram || $socialLinkedin || $socialGithub)
                            <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin-bottom: 24px;">
                                <tr>
                                    @if($socialFacebook)
                                    <td style="padding: 0 5px;">
                                        <a href="{{ $socialFacebook }}" class="social-icon" style="display: inline-block; width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.06); text-align: center; line-height: 38px; font-size: 15px; font-weight: 700; color: rgba(255,255,255,0.45);">f</a>
                                    </td>
                                    @endif
                                    @if($socialTwitter)
                                    <td style="padding: 0 5px;">
                                        <a href="{{ $socialTwitter }}" class="social-icon" style="display: inline-block; width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.06); text-align: center; line-height: 38px; font-size: 14px; font-weight: 700; color: rgba(255,255,255,0.45);">𝕏</a>
                                    </td>
                                    @endif
                                    @if($socialInstagram)
                                    <td style="padding: 0 5px;">
                                        <a href="{{ $socialInstagram }}" class="social-icon" style="display: inline-block; width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.06); text-align: center; line-height: 38px; font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.45);">ig</a>
                                    </td>
                                    @endif
                                    @if($socialLinkedin)
                                    <td style="padding: 0 5px;">
                                        <a href="{{ $socialLinkedin }}" class="social-icon" style="display: inline-block; width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.06); text-align: center; line-height: 38px; font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.45);">in</a>
                                    </td>
                                    @endif
                                    @if($socialGithub)
                                    <td style="padding: 0 5px;">
                                        <a href="{{ $socialGithub }}" class="social-icon" style="display: inline-block; width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.06); text-align: center; line-height: 38px; font-size: 15px; font-weight: 700; color: rgba(255,255,255,0.45);">⌘</a>
                                    </td>
                                    @endif
                                </tr>
                            </table>
                            @endif

                            <!-- Quick Links -->
                            <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 0 12px; border-right: 1px solid rgba(255,255,255,0.08);">
                                        <a href="{{ $siteUrl }}" style="color: rgba(255,255,255,0.4); font-size: 12px; font-weight: 500;">Website</a>
                                    </td>
                                    @if($contactEmail)
                                    <td style="padding: 0 12px; border-right: 1px solid rgba(255,255,255,0.08);">
                                        <a href="mailto:{{ $contactEmail }}" style="color: rgba(255,255,255,0.4); font-size: 12px; font-weight: 500;">Contact</a>
                                    </td>
                                    @endif
                                    <td style="padding: 0 12px;">
                                        <a href="{{ $siteUrl }}/services" style="color: rgba(255,255,255,0.4); font-size: 12px; font-weight: 500;">Services</a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Company Info -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="font-size: 12px; color: rgba(255,255,255,0.2); line-height: 1.7;">
                                        <p style="margin-bottom: 4px;">
                                            <a href="{{ $siteUrl }}" style="color: rgba(255,255,255,0.35); font-weight: 600; font-size: 13px;">{{ $siteName }}</a>
                                            @if($tagline) <span style="color: rgba(255,255,255,0.15);">·</span> {{ $tagline }}@endif
                                        </p>
                                        @if($address)<p style="margin-bottom: 4px;">{{ $address }}</p>@endif
                                        @if($contactEmail)
                                        <p style="margin-bottom: 4px;">
                                            <a href="mailto:{{ $contactEmail }}" style="color: {{ $accentGlow }}; font-size: 12px;">{{ $contactEmail }}</a>
                                            @if($contactPhone) <span style="color: rgba(255,255,255,0.12);">·</span> <span style="color: rgba(255,255,255,0.3);">{{ $contactPhone }}</span>@endif
                                        </p>
                                        @endif
                                        <p style="margin-top: 16px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.04); color: rgba(255,255,255,0.15); font-size: 11px;">
                                            {{ $copyright }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

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
