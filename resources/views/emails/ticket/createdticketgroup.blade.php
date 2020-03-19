@extends('emails.emaillayout')

@section('content')

<p>Dear {{ $ticket->group->group_name }},</p>

<p>Kindly assign agent to the following ticket:</p>

<a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a>

@endsection
