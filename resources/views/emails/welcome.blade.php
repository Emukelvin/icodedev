@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    We're thrilled to have you on board! Your account has been successfully created and you now have full access to your personalized client dashboard.
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

<p style="font-size: 14px; color: #94a3b8; line-height: 1.7; margin-bottom: 8px;">
    From your dashboard, you can:
</p>
<table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">✓ &nbsp;Track your projects in real-time</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">✓ &nbsp;View and pay invoices online</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">✓ &nbsp;Communicate directly with your development team</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">✓ &nbsp;Request quotes for new projects</td></tr>
</table>
@endsection
