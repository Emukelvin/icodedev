@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    Thank you for creating your account! Please verify your email address to get full access to your dashboard and all features.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Account</span><br>
                        <span style="color: #ffffff; font-size: 14px; font-weight: 600;">{{ $user->name }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Email</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ $user->email }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- CTA Button --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 28px 0;">
    <tr>
        <td align="center">
            <!--[if mso]>
            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $verificationUrl }}" style="height:48px;v-text-anchor:middle;width:280px;" arcsize="25%" fillcolor="#6366f1">
                <w:anchorlock/>
                <center style="color:#ffffff;font-family:Arial,sans-serif;font-size:14px;font-weight:bold;">Verify Email Address</center>
            </v:roundrect>
            <![endif]-->
            <!--[if !mso]><!-->
            <a href="{{ $verificationUrl }}" class="btn" style="display: inline-block; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #ffffff; font-weight: 700; font-size: 14px; text-decoration: none; padding: 14px 40px; border-radius: 12px; letter-spacing: 0.3px;">
                ✓ &nbsp;Verify Email Address
            </a>
            <!--<![endif]-->
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 8px;">
    This verification link will expire in 60 minutes. If you did not create an account, no further action is required.
</p>

{{-- Fallback URL --}}
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top: 24px;">
    <tr>
        <td style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 16px;">
            <p style="color: rgba(255,255,255,0.4); font-size: 11px; margin: 0 0 8px 0;">If the button doesn't work, copy and paste this link into your browser:</p>
            <p style="color: #818cf8; font-size: 11px; word-break: break-all; margin: 0;">{{ $verificationUrl }}</p>
        </td>
    </tr>
</table>
@endsection
