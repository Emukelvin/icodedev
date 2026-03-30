@extends('emails.template')

@section('content')
<div style="font-size: 15px; color: #cbd5e1; line-height: 1.8;">
    {!! nl2br(e($body)) !!}
</div>
@endsection
