@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    Thank you for reaching out! We've received your quote request and our team is already reviewing the details.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Service</span><br>
                        <span style="color: #ffffff; font-size: 14px; font-weight: 600;">{{ $quote->service_type }}</span>
                    </td>
                </tr>
                @if($quote->estimated_budget)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Budget</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ number_format($quote->estimated_budget, 2) }}</span>
                    </td>
                </tr>
                @endif
                @if($quote->timeline)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Timeline</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ $quote->timeline }}</span>
                    </td>
                </tr>
                @endif
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 14px; color: #94a3b8; line-height: 1.7; margin-bottom: 8px;">
    <strong style="color: #e2e8f0;">What happens next?</strong>
</p>
<table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">1. &nbsp;Our team reviews your requirements</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">2. &nbsp;We prepare a detailed proposal & estimate</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">3. &nbsp;You'll receive a personalized quote within 24–48 hours</td></tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    If you have any urgent questions, feel free to reply to this email or contact us directly.
</p>
@endsection
