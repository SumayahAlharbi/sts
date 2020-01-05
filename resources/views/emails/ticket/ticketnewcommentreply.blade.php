@extends('emails.emaillayout')

@section('content')

<p>A new reply by {{ $comment->user->name }} to your comment on Ticket #{{ $ticket->id }}</p>

<p><a href='{!!url('ticket/'. $ticket->id)!!}'>{{ $ticket->ticket_title }}</a></p>

{{-- <p>Reply body: {{$comment->body}}</p> --}}
{{-- <p>by:  {{ $comment->user->name }}</p> --}}


@endsection
