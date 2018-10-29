@extends('layouts.app')

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
   Ticket Details
  </div>


  <div class="card-body">


    <div class="row">
      <div class="col-sm-12">
        <h4 class="card-title">{{$tickets->ticket_title}} <small class="text-muted"> in {{$tickets->location->location_name}}</small></h4>
        <h5 class="card-subtitle mb-2 text-muted">by {{$tickets->created_by_user->name}} {{$tickets->created_at->diffForHumans() }}</h5>
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

    {{-- <div class="form-group">
      <label for="name">Ticket Title:</label>
      <input type="text" readonly class="form-control-plaintext" id="ticket_title" value="{{$tickets->ticket_title}}">
      </div>
    <dl class="row">
      <dt class="col-sm-3">Title</dt>
      <dd class="col-sm-9">{{$tickets->ticket_title}}</dd>

      <dt class="col-sm-3">Content</dt>
      <dd class="col-sm-9">
        {{$tickets->ticket_content}}
      </dd>

      <dt class="col-sm-3">Category</dt>
      <dd class="col-sm-9">
        {{$tickets->category->category_name}}
      </dd>

      <dt class="col-sm-3">Location</dt>
      <dd class="col-sm-9">
        {{$tickets->location->location_name}}
      </dd>

      <dt class="col-sm-3">Assignee</dt>
      <dd class="col-sm-9">
        @foreach($tickets->user as $ticket_assignee)
          {{$ticket_assignee->name}}
        @endforeach
      </dd>

      <dt class="col-sm-3">Created by</dt>
      <dd class="col-sm-9">
        @foreach($tickets->user as $ticket_assignee)
          {{$ticket_assignee->name}}
        @endforeach
      </dd>

      <dt class="col-sm-3">Requested by</dt>
      <dd class="col-sm-9">
        @foreach($tickets->user as $ticket_assignee)
          {{$ticket_assignee->name}}
        @endforeach
      </dd>

      <dt class="col-sm-3">Created at</dt>
      <dd class="col-sm-9">
        {{$tickets->created_at->diffForHumans() }}
      </dd> --}}


    {{-- Assignee: {{$tickets->user}} --}}

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
</div>
</div></div>
@endsection
