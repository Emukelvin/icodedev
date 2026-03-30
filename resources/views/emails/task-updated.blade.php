@extends('emails.template')

@section('content')
@php
    $typeLabels = [
        'status' => 'Status Update',
        'comment' => 'New Comment',
        'file' => 'File Uploaded',
    ];
    $typeColors = [
        'status' => ['bg' => 'rgba(99, 102, 241, 0.08)', 'border' => 'rgba(99, 102, 241, 0.15)', 'badge_bg' => 'rgba(99, 102, 241, 0.15)', 'badge_color' => '#818cf8'],
        'comment' => ['bg' => 'rgba(234, 179, 8, 0.08)', 'border' => 'rgba(234, 179, 8, 0.15)', 'badge_bg' => 'rgba(234, 179, 8, 0.15)', 'badge_color' => '#eab308'],
        'file' => ['bg' => 'rgba(16, 185, 129, 0.08)', 'border' => 'rgba(16, 185, 129, 0.15)', 'badge_bg' => 'rgba(16, 185, 129, 0.15)', 'badge_color' => '#10b981'],
    ];
    $colors = $typeColors[$updateType] ?? $typeColors['status'];
@endphp

<p style="font-size: 15px; color: #cbd5e1; line-height: 1.7; margin-bottom: 20px;">
    There's an update on one of your project tasks:
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
    <tr>
        <td style="background: {{ $colors['bg'] }}; border: 1px solid {{ $colors['border'] }}; border-radius: 12px; padding: 20px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="display: inline-block; padding: 4px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; background: {{ $colors['badge_bg'] }}; color: {{ $colors['badge_color'] }}; text-transform: uppercase; letter-spacing: 0.5px;">{{ $typeLabels[$updateType] ?? 'Update' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Task</span><br>
                        <span style="color: #ffffff; font-size: 16px; font-weight: 700;">{{ $task->title }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Project</span><br>
                        <span style="color: #ffffff; font-size: 14px;">{{ $task->project?->title ?? 'N/A' }}</span>
                    </td>
                </tr>
                @if($detail)
                <tr>
                    <td style="padding: 8px 0;">
                        <span style="color: rgba(255,255,255,0.4); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $updateType === 'status' ? 'New Status' : 'Details' }}</span><br>
                        <span style="color: #e2e8f0; font-size: 14px;">{{ $updateType === 'status' ? ucfirst(str_replace('_', ' ', $detail)) : Str::limit($detail, 200) }}</span>
                    </td>
                </tr>
                @endif
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: rgba(255,255,255,0.35); line-height: 1.6;">
    View the full details and respond from your project dashboard.
</p>
@endsection
