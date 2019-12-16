@extends('emails.emaillayout')

@section('content')

<p>Dear {{ $ticket->requested_by_user->name }},</p>

<p>Kindly note that we received your below ticket:</p>

<a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a>

@endsection
