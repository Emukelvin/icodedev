@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    You have a new message{{ isset($senderName) ? " from <strong style='color: #ffffff;'>{$senderName}</strong>" : '' }}. Here's a preview:
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                @isset($senderName)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">From</span><br>
                        <span style="color: #ffffff; font-size: 14px; font-weight: 600;">{{ $senderName }}</span>
                    </td>
                </tr>
                @endisset
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Message</span><br>
                        <span style="color: #e2e8f0; font-size: 14px; line-height: 1.6; font-style: italic;">"{{ Str::limit($messageBody, 250) }}"</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    Reply directly from your dashboard to continue the conversation.
</p>
@endsection
