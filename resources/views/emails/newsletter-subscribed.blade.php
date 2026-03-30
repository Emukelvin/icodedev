@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    Thank you for subscribing to our newsletter! You'll now receive the latest articles, tech insights, tutorials, and company updates directly in your inbox.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Subscribed Email</span><br>
                        <span style="color: #ffffff; font-size: 14px; font-weight: 600;">{{ $email }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 14px; color: #94a3b8; line-height: 1.7; margin-bottom: 8px;">
    Here's what you can expect:
</p>
<table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">✓ &nbsp;Web development tips and best practices</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">✓ &nbsp;New project showcases and case studies</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">✓ &nbsp;Industry news and technology trends</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">✓ &nbsp;Exclusive offers and announcements</td></tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    In the meantime, check out our latest blog posts for great content on web development and technology.
</p>
@endsection
