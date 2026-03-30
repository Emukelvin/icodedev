@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    Your project has been submitted and is now in our system. Our team will review it and get started shortly.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Project Name</span><br>
                        <span style="color: #ffffff; font-size: 16px; font-weight: 700;">{{ $project->title }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Status</span><br>
                        <span style="display: inline-block; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; background: rgba(99, 102, 241, 0.15); color: #818cf8;">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Priority</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ ucfirst($project->priority) }}</span>
                    </td>
                </tr>
                @if($project->deadline)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Deadline</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ $project->deadline->format('M d, Y') }}</span>
                    </td>
                </tr>
                @endif
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    You'll receive updates as your project progresses. Track everything in real-time from your dashboard.
</p>
@endsection
