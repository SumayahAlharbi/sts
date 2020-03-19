@extends('layouts.material')
@section('title', $tickets->ticket_title)
@section('content')



<div class='container'>
  @if(session()->get('success'))
  <div class="alert alert-success">
    {{ session()->get('success') }}
  </div><br />
  @endif

  @if(session()->get('errors'))
  <div class="alert alert-danger">
    {{ session()->get('errors') }}
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

    <!-- condition if ticket is completed & current user is the requested by -->
    @if(@isset($tickets->requested_by_user->id) && Auth::user()->id == $tickets->requested_by_user->id)
    @if ($tickets->status->status_name == "Completed" && $tickets->rating ==NULL)
    @can('rate ticket')
    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#rateModal" data-whatever="@rate" title="Rate"><i class="fas fa-star"></i></button>
    @push('scripts')
    <script src="{{ asset('js/openRating.js') }}"></script>
    @endpush
    @endcan
    @endif
    @endif

    @if ($tickets->rating)
    @if ($tickets->rating->rating_value == '1')
    <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="left" title="Very poor" id="rateTooltip"><i class="fas fa-angry"></i></button>
    @endif

    @if ($tickets->rating->rating_value == '2')
    <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="left" title="Poor" id="rateTooltip"><i class="fas fa-frown"></i></button>
    @endif

    @if ($tickets->rating->rating_value == '3')
    <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="left" title="Fair" id="rateTooltip"><i class="fas fa-meh"></i></button>
    @endif

    @if ($tickets->rating->rating_value == '4')
    <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="left" title="Good" id="rateTooltip"><i class="fas fa-smile"></i></button>
    @endif

    @if ($tickets->rating->rating_value == '5')
    <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="left" title="Excellent" id="rateTooltip"><i class="fas fa-grin-stars"></i></button>
    @endif
    @endif

    @if($userGroupsIdArray == null or (!in_array($tickets->group_id, $userGroupsIdArray) and !auth()->user()->hasRole('admin')))
    {{-- @can('update ticket')<a class="btn btn-outline-success" href="{{ route('ticket.edit',$tickets->id)}}" title="Edit" role="button"><i class="far fa-edit"></i></a>@endcan --}}
    {{-- @can('assign ticket')<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#assignModal" data-whatever="@assign" title="Assign"><i class="fas fa-users"></i></button>@endcan --}}
    {{-- @can('change ticket status')<button type="button" title="Status" class="btn btn-outline-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-check-square"></i></button>@endcan --}}

    @elseif(in_array($tickets->group_id, $userGroupsIdArray) and (auth()->user()->can('view group tickets')) or auth()->user()->hasRole('admin'))
    @can('update ticket')<a class="btn btn-outline-success" href="{{ route('ticket.edit',$tickets->id)}}" title="Edit" role="button"><i class="far fa-edit"></i></a>@endcan
    @can('assign ticket')<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#assignModal" data-whatever="@assign" title="Assign"><i class="fas fa-users"></i></button>@endcan
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

    @elseif(in_array($tickets->group_id, $userGroupsIdArray) and (auth()->user()->can('change ticket status')) and in_array($tickets->id, $agentTicketIdArray))
    @can('change ticket status')<button type="button" title="Status" class="btn btn-outline-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-check-square"></i></button>@endcan

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
      @foreach ($statuses as $status)
      @if($status != $tickets->status)
      <a class='dropdown-item' href='{{url('ticket/ChangeTicketStatus')}}/{{$status->id}}/{{$tickets->id}}'>{{$status->status_name}}</a>
      @endif
      @endforeach
    </div>
    
    @endif

    @if (isset($previous))
    <a class="btn btn-outline-secondary" href="{{ route('ticket.show',$previous->id)}}" title="Previous" role="button"><i class="fas fa-chevron-left"></i></a>
    @endif

    @if (isset($next))
    <a class="btn btn-outline-secondary" href="{{ route('ticket.show',$next->id)}}" title="Next" role="button"><i class="fas fa-chevron-right"></i></a>
    @endif

  </div>

  <!-- Rating Modal -->
  <div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel2">Rate your completed ticket</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{url('ticket/storeTicketRating')}}" method="post">

            @csrf
            <input type="hidden" name="ticket_id" value="{{$tickets->id}}">

            <div class="form-group col-md-12">
              <label for="name">Rating Scale</label>

              <div class="btn-group customRating">

                <label class="btn btn-outline-primary rating" data-toggle="tooltip" data-placement="bottom" title="Very poor">
                  <input type="radio" name="rateScore" value="1"> <i class="fas fa-angry"></i>
                </label>

                <label class="btn btn-outline-primary rating" data-toggle="tooltip" data-placement="bottom" title="Poor">
                  <input type="radio" name="rateScore" value="2"> <i class="fas fa-frown-open"></i>
                </label>

                <label class="btn btn-outline-primary rating" data-toggle="tooltip" data-placement="bottom" title="Fair">
                  <input type="radio" name="rateScore" value="3"> <i class="fas fa-meh"></i>
                </label>

                <label class="btn btn-outline-primary rating" data-toggle="tooltip" data-placement="bottom" title="Good">
                  <input type="radio" name="rateScore" value="4"> <i class="fas fa-smile"></i>
                </label>

                <label class="btn btn-outline-primary rating" data-toggle="tooltip" data-placement="bottom" title="Excellent">
                  <input type="radio" name="rateScore" value="5"> <i class="fas fa-grin-stars"></i>
                </label>
              </div>
              <br><br>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End of Rating Modal -->

  <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel1">Assign an agent to this ticket</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{url('ticket/addTicketAgent')}}" method="post">

            @csrf
            <input type="hidden" name="ticket_id" value="{{$tickets->id}}">

            <div class="form-group col-md-12">
              <label for="name">Agent list</label>
              <select name="user_id" id="" data-show-subtext="true" data-live-search="true" class="selectpicker form-control">
                <option selected disabled value> -- Choose an Agent -- </option>
                @foreach($group_users_not_ticket_agents as $group_user)
                <option value="{{$group_user->id}}">{{$group_user->name}}</option>
                @endforeach
              </select>
            </div>


            <!-- unassign Users from Ticket -->
            <div class="form-group">
              @if (!$TicketAgents->isEmpty())
              <h5>Ticket Assigned to:</h5>
              @foreach($TicketAgents as $TicketAgent)
              <a class='btn btn-primary' @can('unassign ticket') onclick="return confirm('Do you really want to unassign {{$TicketAgent->name}} ?');" href='{{url('ticket/removeTicketAgent')}}/{{$TicketAgent->id}}/{{$tickets->id}}' @endcan data-activates=''><i class="fas fa-user-times"></i> {{$TicketAgent->name}} </a>
              @endforeach
              @endif
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
      @elseif ($tickets->status->status_name == 'In Progress') ribbon-primary
      @else ribbon-default
      @endif">
          {{$tickets->status->status_name}}
        </div>


        <div class="card-body">
          <div class="row">
            <div class="col-md-12">

              <h3 class="card-title">
                <span class="text-muted" title="Ticket Number">
                  #{{$tickets->id}}
                </span>

                {{title_case($tickets->ticket_title)}}
              </h3>

              <h6 class="card-subtitle mb-2 text-muted">

                <span class="label label-light-inverse" @isset($tickets->group->group_description)
                  title="{{$tickets->group->group_description}}"
                  @endisset>
                  <i class="fas fa-users"></i>
                  {{$tickets->group->group_name}}
                </span>
                <span class="label label-light-inverse">
                  <i class="fas fa-exclamation-circle"></i>
                  {{$tickets->priority}}
                </span>
                <span class="label label-light-inverse" @isset($tickets->location->location_description)
                  title="{{$tickets->location->location_description}}"
                  @endisset>

                  <i class="far fa-building"></i>
                  @isset($tickets->location->location_name)
                  {{$tickets->location->location_name}}
                  @endisset

                </span> <span class="label label-light-inverse">
                  <i class="fas fa-door-open"></i>
                  {{$tickets->room_number}}</span>
                <span class="label label-light-inverse">
                  <i class="fas fa-user-plus"></i>
                  @isset($tickets->created_by_user->name)
                  {{$tickets->created_by_user->name}}
                  @endisset
                </span>
                <span class="label label-light-inverse">
                  <i class="far fa-user"></i>
                  @isset($tickets->requested_by_user->name)
                  {{$tickets->requested_by_user->name}}
                  @endisset
                </span>
                <span class="label label-light-inverse">
                  <i class="fas fa-bookmark"></i>
                  @isset($tickets->category->category_name)
                  {{$tickets->category->category_name}}
                  @endisset
                </span>
                <span class="label label-light-inverse"><i class="far fa-clock"></i>
                  {{$tickets->created_at->diffForHumans()}}
                </span>
                <span class="label label-light-inverse"><i class="fas fa-stopwatch"></i>
                  {{$tickets->due_date}}
                </span>
              </h6>
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
          <p class="card-text">{!! $tickets->ticket_content !!}</p>
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
            <!-- changes -->
            <!-- ticket creation -->
            @if ($activityTicket->description == 'created')
            <div class="d-flex flex-row comment-row">
              <div class="p-2"><span>{!! Avatar::create($activityTicket->causer->name)->setFontSize(20)->setDimension(50, 50)->toSvg(); !!}</span></div>
              <div class="comment-text w-100">
                <h5>
                  {{$activityTicket->causer->name}}
                </h5>
                {{--<p class="m-b-5"><span class="label label-light-info">{{$activityTicket->description}}</span> {{ $activityTicket->subject->ticket_title }}</p>--}}
                <div class="comment-footer">
                  <p class="m-b-5"><span class="label label-light-info">{{$activityTicket->description}}</span> {{ $activityTicket->subject->ticket_title }}</p>
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
            @endif
            <!-- end changes -->
            <!-- changes -->
            <!-- ticket status -->
            @if( isset( $activityTicket->changes['attributes']['status_id'] ))
            @if ($activityTicket->description != 'created' && $activityTicket->description !='deleted')
            <div class="d-flex flex-row comment-row">
              <div class="p-2"><span>{!! Avatar::create($activityTicket->causer->name)->setFontSize(20)->setDimension(50, 50)->toSvg(); !!}</span></div>
              <div class="comment-text w-100">
                <h5>
                  {{$activityTicket->causer->name}}
                </h5>
                <div class="comment-footer">
                  {{--@if (json_encode($activityTicket->changes['attributes']['status_id']) !== '3')--}}
                  @foreach ($statuses as $status)
                  @if($status->id == $activityTicket->changes['attributes']['status_id'])
                  <p><span class="label label-light-info"> {{$activityTicket->description}} </span> Status to <span class="label label-light-info"> {{$status->status_name}} </span> </p>
                  @endif
                  @endforeach
                  <span class="text-muted pull-right">{{$activityTicket->created_at->diffForHumans()}}</span>
                </div>
              </div>
            </div>
            @endif
            @endif
            <!-- end changes -->
            <!-- changes -->
            <!-- ticket assigned and unassigned agent -->
            @if( isset( $activityTicket->changes['attributes']['user_id'] ))
            <div class="d-flex flex-row comment-row">
              <div class="p-2"><span>{!! Avatar::create($activityTicket->causer->name)->setFontSize(20)->setDimension(50, 50)->toSvg(); !!}</span></div>
              <div class="comment-text w-100">
                <h5>
                  {{$activityTicket->causer->name}}
                </h5>
                <div class="comment-footer">
                  @foreach ($users as $user)
                  @if($user->id == $activityTicket->changes['attributes']['user_id'])
                  <p><span class="label label-light-info"> {{$activityTicket->description}} </span> {{$user->name}}</p>
                  @endif
                  @endforeach
                  <span class="text-muted pull-right">{{$activityTicket->created_at->diffForHumans()}}</span>
                </div>
              </div>
            </div>
            @endif
            <!-- end changes -->
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
    <div class="card comment-scroll">
      <div class="card-body">
        <h4 class="card-title">Comments</h4>
      </div>
      <!-- ============================================================== -->
      <!-- Comment widgets -->
      <!-- ============================================================== -->
      <div class="comment-widgets">

        {{-- end comment new --}}
        <script src="/vendor/ckeditor/ckeditor.js"></script>


        @include('comments._comment_replies', ['comments' => $tickets->comments, 'ticket_id' => $tickets->id])

        <div class="col-lg-12 add-comment-box">
          <hr />
          <h4>Add comment</h4> <a href="#" class="reply-cancel" id="myCANCEL" style="display:none;">cancel?</a>
          <form method="post" action="{{ route('comment.add') }}" id="comment-form">
            @csrf
            <div class="form-group">
              <textarea type="text" name="comment_body" id="editor"  class="form-control"></textarea>
              <script>
                      var PLACEHOLDERS = [{
                        id: 1,
                        name: 'Done Reply',
                        title: 'This ticket is done!',
                        description: 'inform that this ticket has been completed.'
                      }
                    ];

                    CKEDITOR.addCss('span > .cke_placeholder { background-color: #ffeec2; }');

                    CKEDITOR.replace('editor', {
                      on: {
                        instanceReady: function(evt) {
                          var itemTemplate = '<li data-id="{id}">' +
                            '<div><strong class="item-title">{name}</strong></div>' +
                            '<div><i>{description}</i></div>' +
                            '</li>',
                            outputTemplate = '{title}<span>&nbsp;</span>';

                          var autocomplete = new CKEDITOR.plugins.autocomplete(evt.editor, {
                            textTestCallback: textTestCallback,
                            dataCallback: dataCallback,
                            itemTemplate: itemTemplate,
                            outputTemplate: outputTemplate
                          });

                          // Override default getHtmlToInsert to enable rich content output.
                          autocomplete.getHtmlToInsert = function(item) {
                            return this.outputTemplate.output(item);
                          }
                        }
                      }
                    });

                    function textTestCallback(range) {
                      if (!range.collapsed) {
                        return null;
                      }

                      return CKEDITOR.plugins.textMatch.match(range, matchCallback);
                    }

                    function matchCallback(text, offset) {
                      var pattern = /\[{2}([A-z]|\])*$/,
                        match = text.slice(0, offset)
                        .match(pattern);

                      if (!match) {
                        return null;
                      }

                      return {
                        start: match.index,
                        end: offset
                      };
                    }

                    function dataCallback(matchInfo, callback) {
                      var data = PLACEHOLDERS.filter(function(item) {
                        var itemName = '[[' + item.name + ']]';
                        return itemName.indexOf(matchInfo.query.toLowerCase()) == 0;
                      });

                      callback(data);
                    }
              </script>
              <input type="hidden" name="ticket_id" value="{{ $tickets->id }}" />
              <input type="hidden" name="comment_id" id="comment_id" value="" />
            </div>
            <blockquote class="m-t-10">
                <p><b>Spell Checking:</b> Right click on the mispealed word holding <span class="label label-light-inverse">ctrl/ cmd</span>.</p>
                <p><b>Auto format:</b> Links, emails and lists (write <span class="label label-light-inverse">*</span> simple followed by a space to start a list in the reply box).</p>
                <p><b>Canned replies:</b> Write <span class="label label-light-inverse">[[</span> to choose from the available premade replies.</p>
            </blockquote>
            <div class="form-group reply-box">
              <input type="submit" class="btn btn-dark" value="Add Comment" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>




</div>
</div>


@endsection
