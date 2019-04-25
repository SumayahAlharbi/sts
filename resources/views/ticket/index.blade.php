@extends('layouts.material')
@section('title', 'Tickets')

@section('content')

@if(session()->get('success'))
  <div class="alert alert-success">
    {{ session()->get('success') }}
  </div><br />
@endif
@if(session()->get('danger'))
  <div class="alert alert-danger">
    {{ session()->get('danger') }}
  </div><br />
@endif

<div class="row">
    <div class="col-12">
      <h1 class="text-center" id="type"></h1>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Support Ticket List</h4>
                {{-- <h6 class="card-subtitle">List of ticket</h6> --}}
                <div class="row">
                  <div class="col-lg-12">
                    @can('create ticket')
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CreateTicketModal" data-whatever="@create" title="Create New Ticket" ><i class="fa fa-plus-circle"></i> New</button>
                    @endcan

                    {{-- @can('create ticket')
                      <a class="btn btn-primary" href="{{ route('ticket.create')}}" title="Create New Ticket" role="button"><i class="fa fa-plus-circle"></i> New</a>
                    @endcan --}}
                    {{-- <button id="btn" class="btn btn-danger">Ready?</button> --}}
                  </div>
                </div>

                <div class="modal fade" id="CreateTicketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">+ New Ticket</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                @if ($errors->any())
                                  <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                  </div><br />
                                @endif
                                  <form method="post" action="{{ route('ticket.store') }}">

                                      <div class="form-group">
                                          @csrf
                                          <label for="name">Ticket Title</label>
                                          <input type="text" class="form-control" name="ticket_title" value="{{ old('ticket_title') }}" autofocus required/>
                                      </div>

                                      <div class="form-group">
                                        <label class="control-label">Priority</label>
                                        <select class="form-control custom-select" name="priority" data-placeholder="Choose a Priority Level">
                                              <option value="Low">Low</option>
                                              <option value="Medium">Medium</option>
                                              <option value="High">High</option>
                                              <option value="Critical">Critical</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                      <label for="name">Due Date (Optional)</label>
                                      <input type="text" id="datetimepicker" placeholder="YYYY-MM-DD hh:mm:ss" class="form-control" name="due_date" value="{{ old('due_date') }}" minlength="19" maxlength="19"/>
                                      <small class="form-control-feedback"> Date/Time Format: {{ $now }} </small>
                                    </div>

                                      <div class="form-group">
                                          <label for="ticket_content">Ticket Content</label>
                                          <textarea name="ticket_content" class="form-control" id="editor" rows="3" value="{{ old('ticket_content') }}" required></textarea>
                                      </div>


                                      <div class="form-group">
                                        <label for="exampleFormControlSelect1">Category</label>
                                        <select class="form-control" name="category_id" id="exampleFormControlSelect1">
                                          @foreach ($categories as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                          @endforeach
                                        </select>
                                      </div>


                                      <div class="form-group">
                                        <label for="exampleFormControlSelect1">Location</label>
                                        <select class="form-control" name="location_id" id="exampleFormControlSelect1">
                                          @foreach ($locations as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                          @endforeach
                                        </select>
                                      </div>

                                    <div class="form-group">
                                      <label for="name">Room Number</label>
                                      <input type="text" class="form-control" name="room_number" value="{{ old('room_number') }}"/>
                                    </div>



                                    <div class="form-group">
                                      <label for="exampleFormControlSelect1">Group</label>
                                      <select required class="form-control" name="group_id" id="exampleFormControlSelect1">
                                        @foreach ($groups as $group)
                                          <option value="{{$group->id}}">{{$group->group_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>




                              <div class="form-group" required>
                                <label for="exampleFormControlSelect1">Requested by</label>
                              <select class="selectpicker form-control" name="requested_by" data-show-subtext="true" data-live-search="true" required>
                                <option selected value> -- Who requested this ticket? -- </option>
                                @foreach ($users as $key => $value)
                                  @if ($key == $created_by->id)
                                  <option value="{{$key}}">(Current) {{$value}}</option>
                                  @else
                                  <option value="{{$key}}">{{$value}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>




                                      <div class="form-group">
                                          <input type="text" class="form-control" name="created_by" value="{{$created_by->id}}" hidden />
                                      </div>
                                      <button type="submit" class="btn btn-block btn-lg btn-primary col-md-12">Create</button>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->



              <table class="footable table m-b-0 toggle-circle" data-sort="false">
                  <thead>



                      <tr>
                          <th> # </th>
                          <th data-hide="phone,tablet" data-ignore="true"> Title </th>
                          <th data-hide="desktop,xdesktop" data-ignore="true"> Title </th>
                          <th> Status </th>

                          <th data-hide="phone">Category</th>
                          @if(count($groups) > 1)
                          <th data-hide="phone">Group</th>
                          @endif
                          <th data-hide="phone">Agents</th>
                          <th data-hide="all">Requested by</th>
                          <th data-hide="all">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($tickets as $ticket)
                      <tr>
                          <td>{{$ticket->id}}</td>
                          <td><a href="{{ route('ticket.show',$ticket->id)}}" title="{{$ticket->ticket_title}}"> {{ str_limit($ticket->ticket_title, 35)}}</a>
                            @if ($ticket->comments()->count() != 0)
                              <span class="badge badge-pill badge-info"> {{$ticket->comments()->count()}}</span>
                            @endif
                            <br>
                            <small class="text-muted"> {{ $ticket->created_at->diffForHumans() }} </small></td>

                          <td>{{ str_limit($ticket->ticket_title, 35)}}
                            @if ($ticket->comments()->count() != 0)
                              <span class="badge badge-pill badge-info"> {{$ticket->comments()->count()}}</span>
                            @endif
                            <br> {{$ticket->created_at->diffForHumans()}}</td>

                          <td title="{{$ticket->status['status_name']}}">
                            @if(auth()->user()->can('change ticket status'))
                               <button class="btn btn-sm @if ($ticket->status['status_name'] == 'Unassigned') btn-danger
                               @elseif ($ticket->status['status_name'] == 'Completed') btn-success
                               @elseif ($ticket->status['status_name'] == 'Pending') btn-warning
                               @else btn-inverse
                               @endif dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 {{$ticket->status['status_name']}}
                               </button>

                               <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                               @foreach ($statuses as $status)
                                 @if($status != $ticket->status)
                                 <a class='dropdown-item' href='{{url('ticket/ChangeTicketStatus')}}/{{$status->id}}/{{$ticket->id}}'>{{$status['status_name']}}</a>
                               @endif
                               @endforeach
                               </div>



                          @else
                            <span class="label
                            @if ($ticket->status['status_name'] == 'Unassigned') label-danger
                            @elseif ($ticket->status['status_name'] == 'Completed') label-success
                            @elseif ($ticket->status['status_name'] == 'Pending') label-warning
                            @else label-inverse
                            @endif">
                            {{$ticket->status['status_name']}}
                          </span>
                          @endif
                          </td>
                          <td>{{$ticket->category['category_name']}}</td>
                          @if(count($groups) > 1)
                          <td>
                            <small title="{{$ticket->group->group_description}}">{{$ticket->group->group_name}}</small>
                          </td>
                           @endif
                          <td>
                          @foreach($ticket->user as $ticket_assignee)
                            <a href="{{url('/profile/' . $ticket_assignee->id)}}">
                          <span class="label label-table label-success">{{$ticket_assignee->name}}</span>
                            </a>
                          @endforeach
                          </td>
                          <td>
                            @isset($ticket->requested_by_user->name)
                              {{$ticket->requested_by_user->name}}
                            @endisset

                          </td>
                          <td>
                            <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
                              @csrf
                              @method('DELETE')
                              <a href="{{ route('ticket.show',$ticket->id)}}" title="Show" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                              @can('update ticket')
                              <a href="{{ route('ticket.edit',$ticket->id)}}" title="Edit" class="btn btn-primary"><i class="far fa-edit"></i></a>
                              @endcan
                              @can('delete ticket')
                              <button class="btn btn-danger" title="Delete" type="submit"><i class="fa fa-trash-alt"></i></button>
                              @endcan
                            </form>
                          </td>

                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                      <tr>
                          <td colspan="6">
                              <div class="text-right">
                                  <ul class="pagination pagination-centered hide-if-no-paging"> </ul>
                              </div>
                          </td>
                      </tr>
                  </tfoot>
              </table>

              <div class="row">
                <div class="col-md-12">
{{ $tickets->onEachSide(1)->links() }}
              </div>
              </div>

            </div>
        </div>
    </div>
</div>
{{-- <script>
var myText = 'Happy New Year 2019 🎉',
    i = 0,
    myBtn = document.getElementById('btn');
myBtn.onclick = function () {

  'use strict';

  var typeWriter = setInterval(function () {
    document.getElementById('type').textContent += myText[i];
    i = i + 1;
   if ( i > myText.length - 1 ) {
     clearInterval(typeWriter);
   }
 }, 100);
$('#btn') .hide();
};


</script> --}}

@endsection
