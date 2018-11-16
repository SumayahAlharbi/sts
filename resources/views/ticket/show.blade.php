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
   Ticket Details @can('update ticket')<a class="btn" href="{{ route('ticket.edit',$tickets->id)}}" role="button">Edit</a>@endcan
@can('change ticket status')
   <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     {{$tickets->status->status_name}}
   </button>
   <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
   @foreach ($statuses as $key => $value)
     {{-- <button class="dropdown-item" type="button">{{$key}}{{$value}}</button> --}}
     <a class='dropdown-item' href='{{url('ticket/ChangeTicketStatus')}}/{{$key}}/{{$tickets->id}}'>{{$value}}</a>
   @endforeach
   </div>
@endcan
  </div>

<div class="card-body">
  <div class="row">
<div class="col-sm-12">
    <div class="row">
      <div class="col-sm-12">
        <h4 class="card-title">{{title_case($tickets->ticket_title)}} <small class="text-muted"> in {{$tickets->location->location_name}}</small></h4>
        <h6 class="card-subtitle mb-2 text-muted">Created by {{$tickets->created_by_user->name}} requested by {{$tickets->requested_by_user->name}} {{$tickets->created_at->diffForHumans() }}</h6>
          <h5>
            <span class="badge badge-warning">Assigned to
              @foreach($tickets->user as $ticket_assignee)
                {{$ticket_assignee->name}}
              @endforeach
            </span>
            <span class="badge badge-warning">{{$tickets->status->status_name}}</span>

            {{-- <form action="{{url('ticket/ChangeTicketStatus')}}" method = "post">
              @csrf --}}
            {{-- <input type="hidden" name = "tickets_id" value = "{{$tickets->id}}"> --}}



            {{-- </form> --}}

{{--
            @foreach ($statuses as $key => $value)
              @if ($key == $ticket->status_id)
           <option selected value="{{$key}}">{{$value}}</option>
           @else
           <option value="{{$key}}">{{$value}}</option>
           @endif
            @endforeach --}}


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
        <input type="submit" class="btn btn-dark" value="Add Comment" />
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
