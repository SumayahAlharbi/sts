@extends('emails.emaillayout')

@section('content')
<p>You have a new ticket assigned to you!</p>

<p>Ticket Number: {{ $ticket->id }}</p>

<p>Title: <a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a></p>

<p>Content:  {{ $ticket->ticket_content }}</p>

<p>Priority:  {{ $ticket->priority }}</p>

<p>At:  {{ $ticket->location->location_name }}</p>

<p>Room:  {{ $ticket->room_number }}</p>

<p>in:  {{ $ticket->category->category_name }}</p>

@isset($ticket->requested_by_user->name)
<p>Requested by:  {{ $ticket->requested_by_user->name }}</p>
@endisset

@endsection
