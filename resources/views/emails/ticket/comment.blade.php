@extends('emails.emaillayout')

@section('content')

<p>A new Comment Added to your Ticket Number: {{ $ticket->id }}</p>

<p>Title: <a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a></p>

<p>Comment body: {{$comment->body}}</p>
<p>by:  {{ $comment->user->name }}</p>


@endsection
