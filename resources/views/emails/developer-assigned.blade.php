@extends('emails.template')

@section('content')
<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    Great news! A dedicated development team has been assigned to your project. Here's who's working on it:
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
                    <td style="padding: 12px 0 4px;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Team Members</span>
                    </td>
                </tr>
                @foreach($developerNames as $name)
                <tr>
                    <td style="padding: 4px 0 4px 12px;">
                        <span style="color: #e2e8f0; font-size: 14px;">👤 {{ $name }}</span>
                    </td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 14px; color: #94a3b8; line-height: 1.7;">
    Your team will begin working on your project and you'll receive notifications as tasks are completed and updates are posted.
</p>
@endsection
