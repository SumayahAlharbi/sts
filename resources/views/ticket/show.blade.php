@extends('layouts.app')
<style>
    .display-comment .display-comment {
        margin-left: 40px;
    }
</style>
@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
   Ticket Details <a class="btn" href="{{ route('ticket.edit',$tickets->id)}}" role="button">Edit</a>
  </div>

<div class="card-body">
  <div class="row">
<div class="col-sm-12">
    <div class="row">
      <div class="col-sm-12">
        <h4 class="card-title">{{title_case($tickets->ticket_title)}} <small class="text-muted"> in {{$tickets->location->location_name}}</small></h4>
        <h6 class="card-subtitle mb-2 text-muted">Created by {{$tickets->created_by_user->name}} requested by {{$tickets->requested_by_user->name}} {{$tickets->created_at->diffForHumans() }}</h6>
          <h5>
            <span class="badge badge-warning">{{$tickets->status->status_name}}</span>
            <span class="badge badge-warning">
              @foreach($tickets->user as $ticket_assignee)
                {{$ticket_assignee->name}}
              @endforeach
            </span>
          </h5>

      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <p>
          {{$tickets->ticket_content}}
        </p>
    </div>
    </div>

<hr />
    <h4>Display Comments</h4>

    @include('comments._comment_replies', ['comments' => $tickets->comments, 'ticket_id' => $tickets->id])

    <hr />
<h4>Add comment</h4>
<form method="post" action="{{ route('comment.add') }}">
    @csrf
    <div class="form-group">
        <input type="text" name="comment_body" class="form-control" />
        <input type="hidden" name="ticket_id" value="{{ $tickets->id }}" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-warning" value="Add Comment" />
    </div>

</div>
</div>
</div>



  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
</div>
</div></div>
@endsection
