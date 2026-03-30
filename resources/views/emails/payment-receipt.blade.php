@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    Your payment has been received and confirmed. Here are the details of your transaction:
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Amount Paid</span><br>
                        <span style="color: #10b981; font-size: 22px; font-weight: 800;">{{ $cs }}{{ number_format($payment->amount, 2) }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Reference</span><br>
                        <span style="color: #ffffff; font-size: 14px; font-family: monospace;">{{ $payment->reference }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Method</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ ucfirst(str_replace('_', ' ', $payment->gateway)) }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Date</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ $payment->updated_at->format('M d, Y \a\t h:i A') }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    This receipt serves as confirmation of your payment. You can view your full payment history from your dashboard.
</p>
@endsection
