@extends('emails.emaillayout')

@section('content')

<p>Dear {{ $ticket->requested_by_user->name }},</p>

<p>Kindly rate your completed ticket,</p>

<p>via this link: <a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a></p>

@endsection
