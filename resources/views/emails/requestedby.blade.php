@extends('emails.emaillayout')

@section('content')

<p>Dear {{ $user->name }},</p>

<p>Kindly note that we received your below ticket,</p>

<a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a>

@endsection
