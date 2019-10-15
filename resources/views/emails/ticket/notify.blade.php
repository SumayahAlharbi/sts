@extends('emails.emaillayout')

@section('content')

<p>Dear {{ $ticket->requested_by_user->name }},</p>

<p>Kindly assign agent to the following ticket,</p>

<a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a>

@endsection
