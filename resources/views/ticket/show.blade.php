@extends('layouts.app')

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
        <h4 class="card-title">{{$tickets->ticket_title}} <small class="text-muted"> in {{$tickets->location->location_name}}</small></h4>
        <h5 class="card-subtitle mb-2 text-muted">Created by {{$tickets->created_by_user->name}} requested by {{$tickets->requested_by_user->name}} {{$tickets->created_at->diffForHumans() }}</h5>
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
