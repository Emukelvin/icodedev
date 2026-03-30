@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    A new invoice has been generated for you. Please review the details below and make payment before the due date.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Invoice Number</span><br>
                        <span style="color: #ffffff; font-size: 14px; font-weight: 600;">#{{ $invoice->invoice_number }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Amount Due</span><br>
                        <span style="color: #6366f1; font-size: 22px; font-weight: 800;">{{ $cs }}{{ number_format($invoice->total, 2) }}</span>
                    </td>
                </tr>
                @if($invoice->due_date)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Due Date</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ $invoice->due_date->format('M d, Y') }}</span>
                    </td>
                </tr>
                @endif
                @if($invoice->project)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Project</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ $invoice->project->title }}</span>
                    </td>
                </tr>
                @endif
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    You can pay securely through your client dashboard using any of our available payment methods.
</p>
@endsection
