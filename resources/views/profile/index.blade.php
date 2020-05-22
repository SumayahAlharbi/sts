@extends('layouts.material')
@section('title', 'Profile')

@section('content')
<div class="container-fluid">
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
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">
                        <div class="card-body">

                            <form method="get" action="{{ route('user.profileSearch') }}"><div class="input-group footable-filtering-search">
                              <label class="sr-only">Search</label>
                              <div class="input-group">
                                <input type="text" name="searchKey" class="form-control" placeholder="Search">
                                <input type="hidden" name="id" value="{{ $user->id }}" />
                                <div class="input-group-append">
                                  <button type="submit" class="btn btn-primary">
                                    <span class="fas fa-search"></span></button>

                                        </div>
                                      </div>
                                    </div>
                                  </form>

                                </div>
                                </div>
                  <div class="card">
                    <div class="card-body">
              <center class="m-t-30">
              {!! Avatar::create($user->name)->setFontSize(30)->setDimension(150, 150)->toSvg(); !!}
              <h4 class="card-title m-t-10">{{$user->name}}</h4>
              <h6 class="card-subtitle">{{$user->email}}</h6>
              <div class="row text-center justify-content-md-center">
              @if(count($user->group) > 0)
              @foreach($user->group as $group)
              <span class="label label-light-inverse" title="{{$group->group_description}}">{{$group->group_name}}</span>
              @endforeach
              @endif
              </div>
              {{-- <div class="row text-center justify-content-md-center m-t-5">
              <i class="fab fa-stack-overflow"> {{count($assigned_tickets)}}</i>
              </div> --}}
              </center>
              </div>
              </div>
              </div>



    <div class="col-lg-8 col-xlg-9 col-md-7">
      <div class="card">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs profile-tab" role="tablist">
          <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#userTickets" role="tab">Assigned Tickets</a> </li>
          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#assets" role="tab">Assets List</a></li>
          @if (Auth::id() == $user->id or auth()->user()->hasRole('admin') )
          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a></li>
          @endif
          {{-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#activity" role="tab">Activity</a> </li> --}}
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="userTickets" role="tabpanel">
            <div class="card-body">
              @if (count($assigned_tickets)>0)
              <table class="footable table m-b-0 toggle-circle" data-sort="false">
                <thead>
                  <tr>
                    <th> # </th>
                    <th data-hide="phone,tablet" data-ignore="true"> Title </th>
                    <th data-hide="desktop,xdesktop" data-ignore="true"> Title </th>
                    <th> Status </th>
                    <th data-hide="phone">Category</th>
                    <th data-hide="all">Requested by</th>
                    <th data-hide="all">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($assigned_tickets as $ticket)
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
    {{ $assigned_tickets->onEachSide(1)->links() }}
            </div>
            </div>
            @endif
          </div>
        </div>

        {{-- Assets List --}}
        <div class="tab-pane" id="assets" role="tabpanel">
          <div class="card-body">
                  <table class="footable table m-b-0 toggle-circle" data-sort="false">
                    <thead>
                      <tr>
                        <th>Serial #</th>
                        <th> Tag </th>
                        <th> Type </th>
                        <th> Model </th>
                        <th> Building </th>
                        <th> Floor </th>
                        <th> Room </th>
                        <th> Relocate </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($assets as $key)
                      <tr>
                        <td>{{$key['serial_number']}}</td>
                        <td>{{$key['tag']}}</td>
                        <td>{{$key['type']}}</td>
                        <td>{{$key['model']}}</td>
                        <td>{{$key['building']}}</td>
                        <td>{{$key['floor']}}</td>
                        <td>{{$key['room']}}</td>
                        @if (isset($key['pending']) AND $key['pending']== 'yes')
                        <td><button type="button" class="btn btn-warning showAssetRelocationDetails" id="{{$key['serial_number']}}">Pending</button></td>
                        @else
                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#SendAssetRelocationForm" data-target-serial_number="{{$key['serial_number']}}" data-target-type="{{$key['type']}}" data-target-tag="{{$key['tag']}}" data-whatever="@asset" title="Send Asset Relocation E-Form" >Relocate</button></td>
                        @endif
                      </tr>
                      @if (isset($key['workflow_step']))
                      <tr>
                        <td colspan="8" style="display:none;" id="current_step-{{$key['serial_number']}}">
                          Waiting for
                          @if ($key['workflow_step'] == '28')
                            Department Head Aproval
                          @elseif ($key['workflow_step'] == '29')
                            IT Collage manager Approval
                          @elseif ($key['workflow_step'] == '30')
                            IT Assets Manager Aprroval
                        </td>
                      </tr>
                      @endif
                      @endif
                      @endforeach
                    </tbody>
                  </table>
          </div>
        </div>
          {{-- end of Assets List --}}

              {{-- user settings --}}
              <div class="tab-pane" id="settings" role="tabpanel">
                  <div class="card-body">
                      {{-- <h4 class="card-title">Account Settings</h4> --}}

                          <table class="table stylish-table">

                              <tbody>
                                  <tr>
                                      <td><h6>Tickets per page</h6><small class="text-muted">Set how many ticket you want to list in a single page.</small></td>
                                      <td class="text-right">
                                          <div class="btn-group">
                                              <button class="btn btn-inverse dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  {{$totalTicketSetting}}
                                            </button>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                  <a class='dropdown-item' href='{{url('ticket/ChangeTicketTotal')}}/{{$user_id}}/10'>10</a>
                                                  <a class='dropdown-item' href='{{url('ticket/ChangeTicketTotal')}}/{{$user_id}}/25'>25</a>
                                                  <a class='dropdown-item' href='{{url('ticket/ChangeTicketTotal')}}/{{$user_id}}/50'>50</a>
                                                  <a class='dropdown-item' href='{{url('ticket/ChangeTicketTotal')}}/{{$user_id}}/100'>100</a>
                                                </div>
                                          </div>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td><h6>Hide completed tickets</h6><small class="text-muted">Hide it from the tickets page (you can still reach it from the dashboard)</small></td>
                                      <td class="text-right">
                                          <div class="switch">
                                              <label>
                                                OFF
                                                {{-- <input type="checkbox" checked=""> --}}
                                                <input data-id="{{$user->id}}" data-setting="hide_completed_tickets" class="toggle-class change-user-setting" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="true" data-off="false" {{ $user->settings()->get('hide_completed_tickets')   == 1 ? 'checked' : '' }}>
                                                <span class="lever switch-col-light-green"></span>
                                                ON
                                              </label>
                                      </div>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>


            </div>
            </div>
            {{-- end of user settings --}}

        {{----------- Profile Activity Tab Start -----------}}

        {{-- <div class="tab-pane" id="activity" role="tabpanel">
          <div class="card-body">

            <table class="footable table m-b-0 toggle-circle" data-sort="false">
              <thead>
                <tr>
                  <th> # </th>
                  <th data-hide="phone,tablet" data-ignore="true"> Action </th>
                  <th data-hide="desktop,xdesktop" data-ignore="true"> Date </th>
                  <th> Value Before </th>
                  <th data-hide="phone">Value After</th>
                </tr>
              </thead>
              <tbody>
                @foreach($activitys as $activitylog)
                <tr>
                  <td>{{$activitylog->id}}</td>
                  <td><span class="label label-light-info">{{$activitylog->description}}</span></td>
                  <td><small class="text-muted">{{$activitylog->created_at->diffForHumans()}}</small></td>
                  <td>
                    @foreach($activitylog->properties['attributes'] as $key => $value)
                    {{$key}} :{{$value}}<br>
                    @endforeach
                  </td>
                  <td>
                    @if (isset($activitylog->properties['old']))
                    @foreach($activitylog->properties['old'] as $key => $value)
                    {{$key}} :{{$value}}<br>
                    @endforeach
                    @endif
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
  {{ $activitys->onEachSide(1)->links() }}
            </div>
            </div>

          </div>
        </div> --}}

        {{----------- Profile Activity Tab End -----------}}

      </div>
    </div>
  </div>
</div>
</div>

<!-- Asset Relocation Form Modal -->
<div class="modal fade" id="SendAssetRelocationForm" data-focus="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel1">Asset Relocation Form</h4>
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
        <form method="post" action="{{ route('assets.relocate') }}">
          <div class="form-group">
            @csrf
            <label for="name">Name</label>
            <input type="text" class="form-control" name="user_name" value="{{$user->name}}" readonly/>
          </div>

          <div class="form-group">
            <label class="control-label">Jop Title</label>
            <input type="text" class="form-control" name="jop_title" required>
          </div>

          <div class="form-group">
            <label class="control-label">Email</label>
            <input type="text" class="form-control" name="email" value="{{$user->email}}" readonly>
          </div>

          <div class="form-group">
            <label class="control-label">Date</label>
          <input type="text" id="datetimepicker" placeholder="YYYY-MM-DD hh:mm:ss" class="form-control" name="date" minlength="19" maxlength="19" readonly required/>
          </div>

          <div class="form-group">
            <label class="control-label">Tel No.</label>
          <input type="text" class="form-control" name="tel_no" required/>
          </div>

          <div class="form-group">
            <label class="control-label">Room No.</label>
          <input type="text" class="form-control" name="room_no" required/>
          </div>

          <div class="form-group">
            <label class="control-label">Badge No.</label>
          <input type="text" class="form-control" name="badge_no" required/>
          </div>

          <div class="form-group">
            <label class="control-label">College</label>
            <select class="form-control custom-select" name="college" data-placeholder="Choose a College" required>
              <option value="COMJ-Male">COMJ-Male</option>
              <option value="COMJ-Female">COMJ-Female</option>
              <option value="Clinical Simulation Center">Clinical Simulation Center</option>
            </select>
          </div>

          <div class="form-group">
            <label class="control-label">Head of Department</label>
          <input type="text" class="form-control" name="head_of_department_name" required/>
          </div>

          <div class="form-group">
            <label class="control-label">Head of Department Email</label>
          <input type="text" class="form-control" name="head_of_department_email" required/>
          </div>

          <div class="form-group">
            <label class="control-label">IT Asset Type</label>
            <input type="text" class="form-control" name="asset_type" readonly/>
          </div>

          <div class="form-group">
            <label class="control-label">Tag No.</label>
          <input type="text" class="form-control" name="tag_no" readonly/>
          </div>

          <div class="form-group">
            <label class="control-label">Serial No.</label>
          <input type="text" class="form-control" name="serial_no" readonly/>
          </div>

          <div class="form-group">
            <label class="control-label">Current Room</label>
          <input type="text" class="form-control" name="current_room" placeholder="Floor.Building.Room number" required/>
          </div>

          <div class="form-group">
            <label class="control-label">New Room</label>
          <input type="text" class="form-control" name="new_room" placeholder="Floor.Building.Room number" required/>
          </div>

          <div class="form-group">
            <label class="control-label">Current Department</label>
            <select class="form-control custom-select" name="current_department1" id="current_department1" data-placeholder="Choose your current department" required>
              <option value=""></option>
              <option value="Dean Office">Dean Office</option>
              <option value="Quality Assurance & Academic Accreditation">Quality Assurance & Academic Accreditation</option>
              <option value="Associate Deans">Associate Deans</option>
              <option value="Research Unit">Research Unit</option>
              <option value="Academic Affairs">Academic Affairs</option>
              <option value="Students Affairs">Students Affairs</option>
              <option value="Clinical Affairs">Clinical Affairs</option>
              <option value="Basic Medical Science">Basic Medical Science</option>
              <option value="Medical Education">Medical Education</option>
              <option value="Medical Library">Medical Library</option>
              <option value="Information Technology">Information Technology</option>
              <option value="Administrative Affairs">Administrative Affairs</option>
              <option value="Well-Student Center">Well-Student Center</option>
              <option value="Assessment Unit">Assessment Unit</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div class="form-group" style="display:none;" id="current_department">
            <label class="control-label">Specify Your Current Department</label>
          <input type="text" class="form-control" name="current_department2"/>
          </div>

          <div class="form-group">
            <label class="control-label">New Department</label>
            <select class="form-control custom-select" name="new_department1" id="new_department1" data-placeholder="Choose your new department" required>
              <option value=""></option>
              <option value="Dean Office">Dean Office</option>
              <option value="Quality Assurance & Academic Accreditation">Quality Assurance & Academic Accreditation</option>
              <option value="Associate Deans">Associate Deans</option>
              <option value="Research Unit">Research Unit</option>
              <option value="Academic Affairs">Academic Affairs</option>
              <option value="Students Affairs">Students Affairs</option>
              <option value="Clinical Affairs">Clinical Affairs</option>
              <option value="Basic Medical Science">Basic Medical Science</option>
              <option value="Medical Education">Medical Education</option>
              <option value="Medical Library">Medical Library</option>
              <option value="Information Technology">Information Technology</option>
              <option value="Administrative Affairs">Administrative Affairs</option>
              <option value="Well-Student Center">Well-Student Center</option>
              <option value="Assessment Unit">Assessment Unit</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div class="form-group" style="display:none;" id="new_department">
            <label class="control-label">Specify Your New Department</label>
          <input type="text" class="form-control" name="new_department2"/>
          </div>

          <div class="form-group">
            <label class="control-label">Justification</label>
            <textarea class="form-control" rows="5" name="justification" required/></textarea>
          </div>

          <button type="submit" class="btn btn-block btn-lg btn-primary col-md-12">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End of Asset Relocation Form Modal -->

<script>
    $(function() {
      $('.change-user-setting').change(function() {
          var setting_value = $(this).prop('checked') == true ? 1 : 0;
          var user_id = $(this).data('id');
          var setting_name = $(this).data('setting');

          $.ajax({
              type: "GET",
              dataType: "json",
              url: '{{ route('user.change.setting') }}',
              data: {'setting_value': setting_value,
              'user_id': user_id,
              'setting_name': setting_name
            },
            success: function (data) {
                // console.log(data.message);
            }
          });
      })
    })

    $('#current_department1').on('change', function() {
      if ($("#current_department1").val() === "other") {
        $("#current_department").show()
      } else {
        $("#current_department").hide()
      }
    });

    $('#new_department1').on('change', function() {
      if ($("#new_department1").val() === "other") {
        $("#new_department").show()
      } else {
        $("#new_department").hide()
      }
    });

    //triggered when modal is about to be shown
    $('#SendAssetRelocationForm').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var tag = $(e.relatedTarget).data('target-tag');
        var serial_number = $(e.relatedTarget).data('target-serial_number');
        var type = $(e.relatedTarget).data('target-type');

        //populate the textbox
        $(e.currentTarget).find('input[name="tag_no"]').val(tag);
        $(e.currentTarget).find('input[name="serial_no"]').val(serial_number);
        $(e.currentTarget).find('input[name="asset_type"]').val(type);
    });

    $(".showAssetRelocationDetails").on('click',function () {
      var serial_number = this.id;
      if($("#current_step-"+serial_number).is(':visible')){
        $("#current_step-"+serial_number).hide();
      } else {
        $("#current_step-"+serial_number).show();
      }
    });

  </script>
@endsection
