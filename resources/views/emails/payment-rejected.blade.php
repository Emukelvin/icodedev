@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    We were unable to approve your recent payment. Please review the details below and contact us if you have any questions.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="display: inline-block; padding: 4px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; background: rgba(239, 68, 68, 0.15); color: #f87171; text-transform: uppercase; letter-spacing: 0.5px;">Not Approved</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Amount</span><br>
                        <span style="color: #f87171; font-size: 22px; font-weight: 800;">{{ $cs }}{{ number_format($payment->amount, 2) }}</span>
                    </td>
                </tr>
                @if($payment->reference)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Reference</span><br>
                        <span style="color: #ffffff; font-size: 14px; font-weight: 600;">{{ $payment->reference }}</span>
                    </td>
                </tr>
                @endif
                @if($payment->method)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Method</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ ucfirst($payment->method) }}</span>
                    </td>
                </tr>
                @endif
                @if($payment->admin_notes)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Reason</span><br>
                        <span style="color: #e2e8f0; font-size: 14px;">{{ $payment->admin_notes }}</span>
                    </td>
                </tr>
                @endif
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 14px; color: #94a3b8; line-height: 1.7; margin-bottom: 8px;">
    <strong style="color: #e2e8f0;">What you can do:</strong>
</p>
<table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">1. &nbsp;Review the reason above (if provided)</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">2. &nbsp;Resubmit payment with correct details</td></tr>
    <tr><td style="padding: 6px 0; color: #94a3b8; font-size: 14px;">3. &nbsp;Contact us if you believe this is an error</td></tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    If you need assistance, please reply to this email or reach out through your client dashboard.
</p>
@endsection
