@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    The status of your project has been updated. Here are the details:
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Project</span><br>
                        <span style="color: #ffffff; font-size: 16px; font-weight: 700;">{{ $project->title }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px 0 8px;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Status Change</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0 8px;">
                        <table role="presentation" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding-right: 8px;">
                                    <span style="display: inline-block; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.5);">{{ ucfirst(str_replace('_', ' ', $oldStatus)) }}</span>
                                </td>
                                <td style="padding-right: 8px; color: rgba(255,255,255,0.3); font-size: 14px;">→</td>
                                <td>
                                    <span style="display: inline-block; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; background: rgba(16, 185, 129, 0.15); color: #10b981;">{{ ucfirst(str_replace('_', ' ', $newStatus)) }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    View the full project details and track progress from your dashboard.
</p>
@endsection
