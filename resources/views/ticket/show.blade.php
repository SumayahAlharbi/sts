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



    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
      @foreach ($statuses as $key => $value)
        <a class='dropdown-item' href='{{url('ticket/ChangeTicketStatus')}}/{{$key}}/{{$tickets->id}}'>{{$value}}</a>
      @endforeach
    </div>




  <!-- sample modal content -->
  <div class="button-box text-right">
      @can('update ticket')<a class="btn btn-outline-success" href="{{ route('ticket.edit',$tickets->id)}}" role="button"><i class="far fa-edit"></i></a>@endcan
      @can('assign ticket')<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#assignModal" data-whatever="@assign"><i class="fas fa-users"></i></button>@endcan
      @can('change ticket status')<button type="button" class="btn btn-outline-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-check-square"></i></button>@endcan
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
          @foreach ($statuses as $key => $value)
            <a class='dropdown-item' href='{{url('ticket/ChangeTicketStatus')}}/{{$key}}/{{$tickets->id}}'>{{$value}}</a>
          @endforeach
        </div>

        {{-- status list menu --}}
      <form style="display:inline;" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
      </form>

  </div>
  <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel1">Assign an agent to this ticket</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <form action="{{url('ticket/addTicketAgent')}}" method = "post">

                  @csrf
                                        <input type="hidden" name = "ticket_id" value = "{{$ticket->id}}">

                                        <div class="form-group col-md-12">
                                          <label for="name">Agent list</label>
                                            <select name="user_id" id="" class = "form-control">
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


              <!-- unassign Users from Ticket -->
      <div class="form-group">
        <h5>Ticket Assigned to:</h5>
      @foreach($TicketAgents as $TicketAgent)
        <a class='btn btn-primary' @can('unassign ticket') onclick="return confirm('Do you really want to unassign {{$TicketAgent->name}} ?');" href='{{url('ticket/removeTicketAgent')}}/{{$TicketAgent->id}}/{{$ticket->id}}'@endcan data-activates=''><i class="fas fa-user-times"></i> {{$TicketAgent->name}} </a>
      @endforeach
    </div>
    </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary">Assign</button>
              </form>
              </div>
          </div>
      </div>
  </div>
  <!-- /.modal -->



                          <div class="row">
                            <div class="col-md-12">
                            <div class="card">
                              <div class="ribbon ribbon-right
                              @if ($tickets->status->status_name == 'Unassigned') ribbon-danger
                              @elseif ($tickets->status->status_name == 'Completed') ribbon-success
                              @elseif ($tickets->status->status_name == 'Pending') ribbon-warning
                              @else ribbon-default
                              @endif">
                              {{$tickets->status->status_name}}
                            </div>


                                <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-12">

                                        <h3 class="card-title">{{title_case($tickets->ticket_title)}}</h3>
                                        <h6 class="card-subtitle mb-2 text-muted"><span class="label label-light-inverse"><i class="fas fa-exclamation-circle"></i>  {{$ticket->priority}}</span> <span class="label label-light-inverse"><i class="far fa-building"></i>  {{$tickets->location->location_name}}</span> <span class="label label-light-inverse"><i class="far fa-building"></i> {{$ticket->room_number}}</span> <span class="label label-light-inverse"><i class="fas fa-user-plus"></i> {{$tickets->created_by_user->name}}</span> <span class="label label-light-inverse"><i class="far fa-user"></i> {{$tickets->requested_by_user->name}}</span> <span class="label label-light-inverse"><i class="far fa-clock"></i> {{$tickets->created_at->diffForHumans()}}</span></h6>
</div>

                                  </div>
                                </div>
                                <div class="card-footer text-muted">
                                  <div class="row">
                                    <div class="col-md-10">
                                        {{-- <h6> Agents </h6> --}}

                                        @foreach($tickets->user as $ticket_assignee)
                                          <span class="label label-light-info">{{$ticket_assignee->name}}</span>
                                        @endforeach

                                      {{-- <span class="badge badge-warning">{{$tickets->status->status_name}}</span> --}}
                                      {{-- <span class="badge badge-warning"> {{$ticket->group->group_name}} </span> --}}
                                    </div>


                                  </div>
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
                                  <h6 class="card-subtitle mb-2 text-muted">Ticket Content</h6>
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
