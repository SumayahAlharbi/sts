@extends('layouts.material')
<style>
    .display-comment .display-comment {
        margin-left: 40px;
    }
</style>
@section('content')



<div class = 'container'>
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif


                          <div class="row">
                            <div class="col-md-12">
                            <div class="card">


                                <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-8">
                                        <h3 class="card-title">{{title_case($tickets->ticket_title)}} <small class="text-muted"> in {{$tickets->location->location_name}} {{$ticket->room_number}}</small></h3>
                                        <h6 class="card-subtitle mb-2 text-muted">Created by {{$tickets->created_by_user->name}} requested by {{$tickets->requested_by_user->name}} {{$tickets->created_at->diffForHumans() }}</h6>
</div>
                                      <div class="col-md-4 text-right">
                                        <!-- Example single danger button -->
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

     <div class="btn-group">

       <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Action
       </button>
       <div class="dropdown-menu dropdown-menu-right">
         @can('update ticket')<a class="btn" href="{{ route('ticket.edit',$tickets->id)}}" role="button">Edit</a>@endcan
         {{-- <a class="dropdown-item" href="#">Another action</a>
         <a class="dropdown-item" href="#">Something else here</a> --}}
         @can('delete ticket')
         <div class="dropdown-divider"></div>
         <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
           @csrf
           @method('DELETE')
           <button class="btn" type="submit">Delete</button>
         </form>
         @endcan
       </div>
     </div>
                                      </div>
                                  </div>                                </div>
                                <div class="card-footer text-muted">
                                  <span class="badge badge-warning">Assigned to
                                    @foreach($tickets->user as $ticket_assignee)
                                      {{$ticket_assignee->name}}
                                    @endforeach
                                  </span>
                                  <span class="badge badge-warning">{{$tickets->status->status_name}}</span> <span class="badge badge-warning"> {{$ticket->priority}} </span> <span class="badge badge-warning"> {{$ticket->group->group_name}} </span>
                            </div>
                            </div>
                          </div>
                          </div>





                          {{-- <div class="row">
                            <div class="col-md-12 text-center">

                                <a class="btn btn-circle btn-lg btn-success"><i class="fa fa-link"></i></a>
                                <a class="btn btn-circle btn-lg btn-success"><i class="fa fa-link"></i></a>
                                <a class="btn btn-circle btn-lg btn-success"><i class="fa fa-link"></i></a>
                                <a class="btn btn-circle btn-lg btn-success"><i class="fa fa-link"></i></a>

                          </div>
                          </div> --}}

                          {{-- <div class="row">
                            <div class="col-md-12 text-center">

                                <button type="button" class="btn btn-success"><i class="fa fa-check"></i> Success</button>
                                <button type="button" class="btn btn-success"><i class="fa fa-check"></i> Success</button>
                                <button type="button" class="btn btn-success"><i class="fa fa-check"></i> Success</button>
                                <button type="button" class="btn btn-success"><i class="fa fa-check"></i> Success</button>

                          </div>
                          </div> --}}


                          <div class="row">
                            <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                </div>
                            </div>
                          </div>
                          </div>


                          <div class="row">
                            <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">
<h4 class="card-title">Comments</h4>

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
                          </div>



<div class="card uper">
  <div class="card-header">
    <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger float-right" type="submit"><i class="fas fa-trash-alt"></i></button>
    </form>
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
        <h4 class="card-title">{{title_case($tickets->ticket_title)}} <small class="text-muted"> in {{$tickets->location->location_name}} {{$ticket->room_number}}</small></h4>
        <h6 class="card-subtitle mb-2 text-muted">Created by {{$tickets->created_by_user->name}} requested by {{$tickets->requested_by_user->name}} {{$tickets->created_at->diffForHumans() }}</h6>
          <h5>
            <span class="badge badge-warning">Assigned to
              @foreach($tickets->user as $ticket_assignee)
                {{$ticket_assignee->name}}
              @endforeach
            </span>
            <span class="badge badge-warning">{{$tickets->status->status_name}}</span> <span class="badge badge-warning"> {{$ticket->priority}} </span> <span class="badge badge-warning"> {{$ticket->group->group_name}} </span>

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
    @can('assign ticket')
    <div class="form-group">
    <h5>Assigne an agent to this ticket</h5>
    </div>

      <form action="{{url('ticket/addTicketAgent')}}" method = "post">

        @csrf
                              <input type="hidden" name = "ticket_id" value = "{{$ticket->id}}">
                              <div class="row">
                              <div class="form-group col-md-6">
                                  <select name="user_id" id="" class = "form-control">
                                      @foreach($users as $user)
                                      <option value="{{$user->id}}">{{$user->name}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="form-group col-md-6">
                              <button class='btn btn-primary'>Assign</button>
                              </div>
                          </form>
                        </div>


                          <!-- unassign Users from Ticket -->
                  <div class="form-group">
                    <h5>Ticket Assigned to:</h5>
                  @foreach($TicketAgents as $TicketAgent)
                    <a class='btn btn-primary' @can('unassign ticket') href='{{url('ticket/removeTicketAgent')}}/{{$TicketAgent->id}}/{{$ticket->id}}'@endcan data-activates=''><i class="fas fa-minus-circle"></i> {{$TicketAgent->name}}  @can('unassign ticket')@endcan </a>
                  @endforeach
                </div>
@endcan

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




</div>
</div></div>
@endsection
