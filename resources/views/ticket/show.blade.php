@extends('layouts.material')
@section('title', $tickets->ticket_title)
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
      @foreach ($statuses as $status)
        @if($status != $tickets->status)
        <a class='dropdown-item' href='{{url('ticket/ChangeTicketStatus')}}/{{$status->id}}/{{$tickets->id}}'>{{$status->status_name}}</a>
        @endif
      @endforeach
    </div>




  <!-- sample modal content -->
  <div class="button-box text-right">
      @can('update ticket')<a class="btn btn-outline-success" href="{{ route('ticket.edit',$tickets->id)}}" title="Edit" role="button"><i class="far fa-edit"></i></a>@endcan
      @can('assign ticket')<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#assignModal" data-whatever="@assign" title="Assign" ><i class="fas fa-users"></i></button>@endcan
      @can('change ticket status')<button type="button" title="Status" class="btn btn-outline-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-check-square"></i></button>@endcan
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
          @foreach ($statuses as $status)
            @if($status != $tickets->status)
            <a class='dropdown-item' href='{{url('ticket/ChangeTicketStatus')}}/{{$status->id}}/{{$tickets->id}}'>{{$status->status_name}}</a>
            @endif
          @endforeach
        </div>

        {{-- status list menu --}}
        @can('delete ticket')
      <form style="display:inline;" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $tickets->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger" title="Delete" type="submit"><i class="fas fa-trash-alt"></i></button>
      </form>
    @endcan

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
                                        <input type="hidden" name = "ticket_id" value = "{{$tickets->id}}">

                                        <div class="form-group col-md-12">
                                          <label for="name">Agent list</label>
                                            <select name="user_id" id="" data-show-subtext="true" data-live-search="true" class="selectpicker form-control">
                                              <option selected disabled value> -- Choose an Agent -- </option>
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


              <!-- unassign Users from Ticket -->
      <div class="form-group">
        <h5>Ticket Assigned to:</h5>
      @foreach($TicketAgents as $TicketAgent)
        <a class='btn btn-primary' @can('unassign ticket') onclick="return confirm('Do you really want to unassign {{$TicketAgent->name}} ?');" href='{{url('ticket/removeTicketAgent')}}/{{$TicketAgent->id}}/{{$tickets->id}}'@endcan data-activates=''><i class="fas fa-user-times"></i> {{$TicketAgent->name}} </a>
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
                                        <h6 class="card-subtitle mb-2 text-muted"><span class="label label-light-inverse"><i class="fas fa-exclamation-circle"></i>  {{$tickets->priority}}</span> <span class="label label-light-inverse"><i class="far fa-building"></i>  {{$tickets->location->location_name}}</span> <span class="label label-light-inverse"><i class="far fa-building"></i> {{$tickets->room_number}}</span> <span class="label label-light-inverse"><i class="fas fa-user-plus"></i> {{$tickets->created_by_user->name}}</span> <span class="label label-light-inverse"><i class="far fa-user"></i>
                                        @isset($tickets->requested_by_user->name)
                                          {{$tickets->requested_by_user->name}}
                                        @endisset
                                      </span> <span class="label label-light-inverse"><i class="far fa-clock"></i> {{$tickets->created_at->diffForHumans()}}</span></h6>
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
                                      {{-- <span class="badge badge-warning"> {{$tickets->group->group_name}} </span> --}}
                                    </div>


                                  </div>
                                  </div>
                            </div>
                          </div>
                          </div>






                          <div class="row">
                            <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">
                                  <h6 class="card-subtitle mb-2 text-muted">Ticket Content</h6>
                                    <p class="card-text">{{$tickets->ticket_content}}</p>
                                </div>
                            </div>
                          </div>
                          </div>


                          <div class="row">
                            <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">
                                      <a class="btn text-muted" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Ticket Activity <i class="far fa-caret-square-down"></i>
                                      </a>
                                      <div class="collapse" id="collapseExample">

                                        @foreach($activityTickets as $activityTicket)
                                          <!-- activity Row -->

                                          <div class="d-flex flex-row comment-row">
                                              <div class="p-2"><span>{!! Avatar::create($activityTicket->causer->name)->setFontSize(20)->setDimension(50, 50)->toSvg(); !!}</span></div>
                                              <div class="comment-text w-100">
                                                  <h5>{{$activityTicket->causer->name}}</h5>
                                                  <p class="m-b-5"><span class="label label-light-info">{{$activityTicket->description}}</span> {{ $activityTicket->subject->ticket_title }}</p>
                                                  <div class="comment-footer">
                                                      <!-- changes -->
                                                      @if( isset( $activityTicket->changes['attributes']['status_id'] ))
                                                          @if (json_encode($activityTicket->changes['attributes']['status_id']) !== '3')
                                                            @foreach ($statuses as $status)
                                                              @if($status->id == $activityTicket->changes['attributes']['status_id'])
                                                                status to <span class="label label-light-info"> {{$status->status_name}} </span>
                                                              @endif
                                                            @endforeach
                                                          @endif
                                                      @endif
                                                      <!-- end changes -->
                                                      <span class="text-muted pull-right">{{$activityTicket->created_at->diffForHumans()}}</span>
                                                      {{-- <span class="label label-light-info">{{$activityTicket->description}}</span> --}}
                                                      {{-- <span class="action-icons">
                                                                  <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                                  <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                                  <a href="javascript:void(0)"><i class="ti-heart"></i></a>
                                                              </span> --}}
                                                  </div>
                                              </div>
                                          </div>
                                          <!-- activity Row -->
                                          @endforeach
                                      </div>
                                </div>
                            </div>
                          </div>
                          </div>







                          {{-- <div class="row">
                            <div class="col-md-12">
                            <div class="card">

                              <div class="card-body">
                                  <h4 class="card-title">Ticket Activity</h4>
                              </div>

                              <!-- ============================================================== -->
                              <div class="comment-widgets">
                                @foreach($activityTickets as $activityTicket)
                                  <!-- activity Row -->

                                  <div class="d-flex flex-row comment-row">
                                      <div class="p-2"><span>{!! Avatar::create($activityTicket->causer->name)->setFontSize(20)->setDimension(50, 50)->toSvg(); !!}</span></div>
                                      <div class="comment-text w-100">
                                          <h5>{{$activityTicket->causer->name}}</h5>
                                          <p class="m-b-5"><span class="label label-light-info">{{$activityTicket->description}}</span> {{ $activityTicket->subject->ticket_title }}</p>
                                          <div class="comment-footer">
                                              <!-- changes -->
                                              @if(array_key_exists('attributes', $activityTicket->changes()->toArray()))
                                              @if (json_encode($activityTicket->changes['attributes']['status_id']) !== null)
                                                @if (json_encode($activityTicket->changes['attributes']['status_id']) !== '3')
                                                @foreach ($statuses as $status)
                                                  @if($status->id == $activityTicket->changes['attributes']['status_id'])
                                                  status to <span class="label label-light-info"> {{$status->status_name}} </span>
                                                  @endif
                                                @endforeach
                                                @endif
                                              @endif
                                              @endif
                                              <!-- end changes -->
                                              <span class="text-muted pull-right">{{$activityTicket->created_at->diffForHumans()}}</span>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- activity Row -->
                                  @endforeach
                              </div>
                            </div>
                          </div>
                          </div> --}}


{{-- start comment new --}}

<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Comments</h4>
        </div>
        <!-- ============================================================== -->
        <!-- Comment widgets -->
        <!-- ============================================================== -->
        <div class="comment-widgets">

{{-- end comment new --}}


                                  @include('comments._comment_replies', ['comments' => $tickets->comments, 'ticket_id' => $tickets->id])

                                <div class="col-lg-12">  <hr />
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
                                </form>
  </div>
                                </div>
                            </div>
                        </div>
                        </div>




</div></div>
@endsection
