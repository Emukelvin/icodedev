@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    Thank you for getting in touch! We've received your message and our team will respond within 24 hours.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                @if($contact->subject)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Subject</span><br>
                        <span style="color: #ffffff; font-size: 14px; font-weight: 600;">{{ $contact->subject }}</span>
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Your Message</span><br>
                        <span style="color: #e2e8f0; font-size: 14px; line-height: 1.6;">{{ Str::limit($contact->message, 300) }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    This is an automated confirmation that your message was received. A real human from our team will follow up shortly.
</p>
@endsection
