@extends('emails.emaillayout')

@section('content')

<p>A new comment by {{ $comment->user->name }} to your Ticket #{{ $ticket->id }}</p>

<p><a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a></p>

{{-- <p>Comment body: {{$comment->body}}</p> --}}
{{-- <p>by:  {{ $comment->user->name }}</p> --}}


@endsection
