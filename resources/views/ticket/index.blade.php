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
{{-- <script src="/vendor/ckeditor/ckeditor.js"></script> --}}
<script>
$(function () {
    $('.myselect').selectpicker();
});        //update group after region select in defult model
        $(document).on('change','.region', function(e){
        var region_id = e.target.value;
        $.getJSON('/getGroups/' + region_id, function(data) {
              $("#groupDiv").show();
              $('#group_id').empty();
              $('#group_id').append("<option value=''>Select your department</option>");
              $.each(data,function(index, subcatObj){
                $('#group_id').append("<option value="+subcatObj.id+">"+subcatObj.group_name+"</option>");

              });
          });

        });
        //update location after group select in defult model
        $(document).on('change','.group', function(e){
        var group_id = e.target.value;
        $.getJSON('/getLocations/' + group_id, function(data) {
              $("#locationDiv").show();
              $('#location_id').empty();
              $('#location_id').append("<option value=''>Select your location</option>");
              $.each(data,function(index, subcatObj){
                $('#location_id').append("<option value="+subcatObj.id+">"+subcatObj.location_name+"</option>");

              });
          });
          $.getJSON('/getCategory/' + group_id, function(data) {
                $("#categoryDiv").show();
                    $('#category_id').empty();
                    $('#category_id').append("<option value=''>Select a category</option>");
                    $.each(data,function(index, subcatObj){
                      $('#category_id').append("<option value="+subcatObj.id+">"+subcatObj.category_name+"</option>");

                });
            });
        });
        //update group after region select in Enduser model
        $(document).on('change','.regionEnduser', function(e){
        var region_id = e.target.value;
        $.getJSON('/getGroups/' + region_id, function(data) {
              $("#groupDivEnduser").show();
              $('#groupEnduser').empty();
              $('#groupEnduser').append("<option value=''>Select department</option>");
              $.each(data,function(index, subcatObj){
                $('#groupEnduser').append("<option value="+subcatObj.id+">"+subcatObj.group_name+"</option>");

              });
          });
        });
        //update location after group select in Enduser model
        $(document).on('change','.groupEnduser', function(e){
          var group_id = e.target.value;
          $.getJSON('/getLocations/' + group_id, function(data) {
                $("#locationDivEnduser").show();
                $('#locationEnduser').empty();
                $('#locationEnduser').append("<option value=''>Select your location</option>");
                $.each(data,function(index, subcatObj){
                  $('#locationEnduser').append("<option value="+subcatObj.id+">"+subcatObj.location_name+"</option>");

                });
            });
          $.getJSON('/getCategory/' + group_id, function(data) {
                $("#categoryDivEnduser").show();
                    $('#categoryEnduser').empty();
                    $('#categoryEnduser').append("<option value=''>Select a category</option>");
                    $.each(data,function(index, subcatObj){
                      $('#categoryEnduser').append("<option value="+subcatObj.id+">"+subcatObj.category_name+"</option>");

                });
            });
        });
</script>
<div class="row">
    <div class="col-12">
      <h1 class="text-center" id="type"></h1>
      {{-- <div class="alert alert-success">version {{$releases->release_version}} has been released 🚀 {{ $releases->created_at->diffForHumans() }}</div> --}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Support Ticket List</h4>
                {{-- <h6 class="card-subtitle">List of ticket</h6> --}}
                <div class="row">
                  <div class="col-lg-11">
                    {{-- @can('create ticket')
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CreateTicketModal" data-whatever="@create" title="Create New Ticket in Your Department as an Agent" ><i class="fa fa-plus-circle"></i> Create Ticket</button>
                    @endcan --}}

                    @can('create ticket')
                      <a class="btn btn-primary create-ticket-button" href="{{ route('ticket.create')}}" role="button" title="Create New Ticket"><i class="fa fa-plus-circle"></i> Create Ticket</a>
                    @endcan

                <!-- End User Create Ticket -->
                {{-- @if(Auth::user()->hasRole('enduser'))
                    @can('end user create ticket')
                          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#EndUserCreateTicketModal" data-whatever="@create" title="Request New Ticket From a Department" ><i class="fas fa-spinner"></i> Request Ticket</button>
                        @endcan
                  @endif

                <div class="modal fade" id="EndUserCreateTicketModal" data-focus="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">+ Request Ticket</h4>
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
                                  <form method="post" action="{{ route('ticket.Enduserstore') }}">

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
                                          <label for="ticket_content">Ticket Content</label>
                                          <textarea name="ticket_content" class="form-control" id="editor" rows="3" value="{{ old('ticket_content') }}" required></textarea>
                                          <script>
                                              CKEDITOR.replace( 'editor' );
                                          </script>
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleFormControlSelect1">Region</label>
                                        <select required class="form-control regionEnduser" name="regionEnduser" id="regionEnduser">
                                          <option value="">None</option>
                                          @foreach ($regions as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                      <div class="form-group" style="display:none;" id="groupDivEnduser">
                                      <label for="exampleFormControlSelect1">Request From</label>
                                      <select required class="form-control groupEnduser" name="groupEnduser" id="groupEnduser">
                                        @foreach ($groups as $group)
                                          <option value="{{$group->id}}">{{$group->group_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>

                                      <div class="form-group" style="display:none;" id="locationDivEnduser">
                                        <label for="exampleFormControlSelect1">Location</label>
                                        <select required class="form-control" name="locationEnduser" id="locationEnduser">
                                          <option value="">None</option>
                                          @foreach ($locations as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                          @endforeach
                                        </select>
                                      </div>

                                      <div class="form-group" style="display:none;" id="categoryDivEnduser">
                                        <label for="exampleFormControlSelect1">Category</label>
                                        <select required class="form-control" name="categoryEnduser" id="categoryEnduser">
                                          <option value="">None</option>
                                          @foreach ($categories as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                          @endforeach
                                        </select>
                                      </div>

                                    <div class="form-group">
                                      <label for="name">Room Number</label>
                                      <input type="text" class="form-control" name="room_number" value="{{ old('room_number') }}"/>
                                    </div>



                              <div class="form-group" required>
                                <label for="exampleFormControlSelect1">Requested by</label>
                              <select class="selectpicker form-control" data-show-subtext="true" data-live-search="true" disabled>
                                @foreach ($users as $key => $value)
                                  @if ($key == $created_by->id)
                                  <option value="{{$key}}">(Current) {{$value}}</option>
                                  <input type="text" class="form-control" name="requested_by" value="{{$key}}" hidden/>
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
                </div> --}}


                <!--/.End User Create Ticket -->

                    {{-- <button id="btn" class="btn btn-danger">Ready?</button> --}}
                  </div>
                  <div class="col-md-1">
                      {{-- <select class="myselect" name="total_tickets" data-style="form-control btn-secondary">
                          <option value="10">10</option>
                          <option value="25">25</option>
                          <option>50</option>
                          <option>100</option>
                      </select>

                      @section('scripts')
                          <script type="text/javascript">
                              $("#country").change(function(){
                                  $.ajax({
                                      url: "{{ route('admin.cities.get_by_country') }}?country_id=" + $(this).val(),
                                      method: 'GET',
                                      success: function(data) {
                                          $('#city').html(data.html);
                                      }
                                  });
                              });
                          </script>
                      @endsection --}}

                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          {{$totalTicketSetting}}
                    </button>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                          <a class='dropdown-item' href='{{url('ticket/ChangeTicketTotal')}}/{{$user_id}}/10'>10</a>
                          <a class='dropdown-item' href='{{url('ticket/ChangeTicketTotal')}}/{{$user_id}}/25'>25</a>
                          <a class='dropdown-item' href='{{url('ticket/ChangeTicketTotal')}}/{{$user_id}}/50'>50</a>
                          <a class='dropdown-item' href='{{url('ticket/ChangeTicketTotal')}}/{{$user_id}}/100'>100</a>
                        </div>
                  </div>
                </div>

                {{-- <div class="col-sm-1">
                    <select class="myselect m-b-20 m-r-10" data-style="btn-primary">
                        <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                        <option data-tokens="mustard">Burger, Shake and a Smile</option>
                        <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                    </select>
                </div> --}}

                <div class="modal fade" id="CreateTicketModal" data-focus="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">+ Create Ticket</h4>
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
                                      <input type="text" id="datetimepicker" placeholder="YYYY-MM-DD hh:mm:ss" class="form-control" name="due_date" value="{{ old('due_date') }}" minlength="19" maxlength="19" readonly/>
                                      {{-- <small class="form-control-feedback"> Date/Time Format: {{ $now }} </small> --}}
                                    </div>

                                      <div class="form-group">
                                          <label for="ticket_content">Ticket Content</label>
                                          <textarea name="ticket_content" class="form-control" id="contentEditor" rows="3" value="{{ old('ticket_content') }}" required></textarea>
                                          {{-- <script>
                                            CKEDITOR.replace( 'contentEditor' );
                                          </script> --}}
                                      </div>

                                      <div class="form-group">
                                        <label for="exampleFormControlSelect1">Region</label>
                                        <select required class="form-control region" name="region" id="region" required>
                                          <option value="">None</option>
                                          @foreach ($regions as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                      <div class="form-group" style="display:none;" id="groupDiv">
                                      <label for="exampleFormControlSelect1">Department</label>
                                      <select required class="form-control group" name="group_id" id="group_id" required>
                                        @foreach ($groups as $group)
                                          <option value="{{$group->id}}">{{$group->group_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>

                                      <div class="form-group" style="display:none;" id="locationDiv">
                                        <label for="exampleFormControlSelect1">Location</label>
                                        <select required class="form-control" name="location_id" id="location_id">
                                          <option value="">None</option>
                                          @foreach ($locations as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                          @endforeach
                                        </select>
                                      </div>

                                      <div class="form-group" style="display:none;" id="categoryDiv">
                                        <label for="exampleFormControlSelect1">Category</label>
                                        <select required class="form-control" name="category_id" id="category_id">
                                          <option value="">None</option>
                                          @foreach ($categories as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                          @endforeach
                                        </select>
                                      </div>

                                    <div class="form-group">
                                      <label for="name">Room Number</label>
                                      <input type="text" class="form-control" name="room_number" value="{{ old('room_number') }}"/>
                                    </div>

                              <div class="form-group" required>
                                <label for="exampleFormControlSelect1">Requested by</label>
                              {{-- <select class="selectpicker form-control" name="requested_by" data-show-subtext="true" data-live-search="true">
                                <option selected value> -- Who requested this ticket? -- </option>
                                @foreach ($users as $key => $value)
                                  @if ($key == $created_by->id)
                                  <option value="{{$key}}">(Current) {{$value}}</option>
                                  @else
                                  <option value="{{$key}}">{{$value}}</option>
                                  @endif
                                @endforeach
                              </select> --}}

                              <select id="ajax-select" class="selectpicker" name="requested_by" data-live-search="true"></select>
                              <input type="text" class="form-control" id="requested_by_name" name="requested_by_name" value="" hidden/>
                            </div>

                            {{-- <script>
                                $(function() {
                                  $('.toggle-class').change(function() {
                                      // var visibility_id = $(this).prop('checked') == true ? 1 : 0;
                                      var userKeyword = $(this).data('id');

                                      $.ajax({
                                          type: "GET",
                                          dataType: "json",
                                          url: '{{ route('graph.users.list') }}',
                                          data: {'userKeyword': userKeyword},
                                        success: function (data) {
                                            // console.log(data.message);
                                        }
                                      });
                                  })
                                })
                              </script> --}}
                              <script>
                              $('.selectpicker').selectpicker().ajaxSelectPicker({
ajax: {

  // data source
  url: '{{ route('graph.users.list') }}',

  // ajax type
  type: 'GET',

  // data type
  dataType: 'json',

  // Use  as a placeholder and Ajax Bootstrap Select will
  // automatically replace it with the value of the search query.
  data: {
    q: '{@{{q}}}'
  }
},

// function to preprocess JSON data
preprocessData: function (data) {
  var i, l = data.length, array = [];
  // var hiddenField = $( "optgroup option:selected" ).text();
  if (l) {
      for (i = 0; i < l; i++) {
          array.push($.extend(true, data[i], {
              text : data[i].displayName,
              value: data[i].mail,
              data : {
                  subtext: data[i].mail
              }
          }));
          // $( "optgroup option:selected" ).text();
      }
      // console.log(hiddenField);
      // console.log(data);
  }
  // You must always return a valid array when processing data. The
  // data argument passed is a clone and cannot be modified directly.
  return array;
  // $( "optgroup option:selected" ).text();
}

});
// var hiddenField = $( "optgroup option:selected" ).text();
// console.log(hiddenField);
                              $(function() {
                                  $('.selectpicker').change(function() {
                                      var hiddenField = $( "optgroup option:selected" ).text();
                                      document.getElementById("requested_by_name").value = hiddenField;
                                      console.log(hiddenField);
                                  })
                                })
                              </script>




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

                          <th data-hide="phone">Group</th>

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
                            <small class="text-muted"><a class="text-muted" title="{{$ticket->created_at}}">  {{ $ticket->created_at->diffForHumans() }} </small></td>

                          <td>{{ str_limit($ticket->ticket_title, 35)}}
                            @if ($ticket->comments()->count() != 0)
                              <span class="badge badge-pill badge-info"> {{$ticket->comments()->count()}}</span>
                            @endif
                            <br> {{$ticket->created_at->diffForHumans()}}</td>

                          <td title="{{$ticket->status['status_name']}}">

                            @if($userGroupsIdArray == null or !in_array($ticket->group_id, $userGroupsIdArray))
                            <span class="label
                            @if ($ticket->status['status_name'] == 'Unassigned') label-danger
                            @elseif ($ticket->status['status_name'] == 'Completed') label-success
                            @elseif ($ticket->status['status_name'] == 'Pending') label-warning
                            @elseif ($ticket->status['status_name'] == 'In Progress') label-primary
                            @else label-inverse
                            @endif">
                            {{$ticket->status['status_name']}}
                          </span>

                            @elseif(in_array($ticket->group_id, $userGroupsIdArray) and (auth()->user()->can('change ticket status')) or auth()->user()->hasRole('admin'))
                            <button class="btn btn-sm @if ($ticket->status['status_name'] == 'Unassigned') btn-danger
                            @elseif ($ticket->status['status_name'] == 'Completed') btn-success
                            @elseif ($ticket->status['status_name'] == 'Pending') btn-warning
                            @elseif ($ticket->status['status_name'] == 'In Progress') btn-primary
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


                       @endif
                       </td>


                          <td>{{$ticket->category['category_name']}}</td>

                          <td>
                            <small title="{{$ticket->group->group_description}}">{{$ticket->group->group_name}}</small>
                          </td>

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
                              <a href="{{ route('ticket.show',$ticket->id)}}" title="Show" class="btn btn-success"><i class="fa fa-eye"></i></a>
                              @if (!empty($userGroupsIdArray))
                              @foreach ($userGroupsIdArray as $userGroup)
                              @if($ticket->group->id == $userGroup)
                              @can('update ticket')
                              <a href="{{ route('ticket.edit',$ticket->id)}}" title="Edit" class="btn btn-warning"><i class="far fa-edit"></i></a>
                              @endcan
                              @can('delete ticket')
                              <button class="btn btn-danger" title="Delete" type="submit"><i class="fa fa-trash-alt"></i></button>
                              @endcan
                              @endif
                              @endforeach
                              @endif
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
var myText = 'Happy New Year 2020 🎉',
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
