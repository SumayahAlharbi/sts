@extends('layouts.material')
@section('title', 'Dashboard')
@section('content')
@section('title', 'Tickets')

    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
            <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><i class="fab fa-stack-overflow"></i> Total Tickets <span class="label label-light-inverse">{{$ticketsStats->count()}}</span></h3>
                            <div id="tickets" style="height:285px; width:100%;"></div>
                        </div>
                        <div>
                            <hr class="m-t-0 m-b-0">
                        </div>
                        <div class="card-body text-center ">
                            <ul class="list-inline m-b-0">
                              <a href="{{url('/statusFilter?status=4')}}">
                                <li>
                                       <h6 class="text-muted text-warning"><span class="label label-warning">Pending {{$ticketsStats->where('status_id','=','4')->count()}}</span></h6></li>
                                     </a>
                                     <a href="{{url('/statusFilter?status=5')}}">
                                <li>
                                    <h6 class="text-muted text-info"><span class="label label-primary"> In Progress {{$ticketsStats->where('status_id','=','5')->count()}}</span></h6></li>
                                  </a>
                                  <a href="{{url('/statusFilter?status=2')}}">
                                <li>
                                    <h6 class="text-muted text-info"><span class="label label-inverse"> Scheduled {{$ticketsStats->where('status_id','=','2')->count()}}</span></h6> </li>
                                  </a>
                                  <a href="{{url('/statusFilter?status=1')}}">
                                <li>
                                    <h6 class="text-muted  text-success"><span class="label label-success"> Completed {{$ticketsStats->where('status_id','=','1')->count()}}</span> </h6> </li>
                                  </a>
                                  <a href="{{url('/statusFilter?status=3')}}">
                                <li>
                                    <h6 class="text-muted  text-danger"><span class="label label-danger"> Unassigned {{$ticketsStats->where('status_id','=','3')->count()}}</span> </h6> </li>
                                  </a>
                            </ul>
                        </div>
                    </div>
             </div>

    </div>

<!-- Show tickets that is due date today in dashboard -->
<div class="row">
            <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><i class="far fa-calendar"></i> Today Tickets <span class="label label-light-inverse">{{$todayTickets->count()}}</span></h3>
                  
                  @if($todayTickets->isEmpty())
                  <th> Nothing is Due Today</th>
                  
                  @else            
                        
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
               
                  
                  @foreach($todayTickets as $ticket)
                  
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
                            @elseif ($ticket->status['status_name'] == 'In Progress') label-primary
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
                  @endif
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
              </div>
            </div>
      </div>
    </div>
                

<!-- Show tickets that is due date today in dashboard -->

                <div class="row">
                  <div class="col-lg-12 col-md-12">
                  <div class="card">

                      <div class="card-body">
                            <a class="btn text-muted" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <h3 class="card-title"> <i class="far fa-caret-square-down"></i>  Releases <span class="label label-warning">New</span> </h3>
                            </a>
                            <div class="collapse" id="collapseExample">
                              <div class="m-t-20 m-b-20">
                              </div>
                              <div class="row">
                              <div class="col-lg-12 col-md-12">

                                <h5><span class="label label-info">v0.4.4</span></h5>

                                  <h5> <span class="label label-success">Add</span> </h5>
                                  <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Dashboard Statuses in 🍩</h5>
                                  <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Due Date in Tickets</h5>
                                  <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Ability To Create/Edit Locations For Admins</h5>
                                  <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Ability To Create/Edit Categories For Admins</h5>
                                  <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Nested Reply To The Comments</h5>


                                </div>
                              </div>
                              <div class="m-t-20 m-b-20">
                              </div>
                              <div class="row">
                              <div class="col-md-12">

                                <h5><span class="label label-info">v0.4.3</span></h5>

                                  <h5> <span class="label label-success">Add</span> </h5>
                                  <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Search To Agent Profile</h5>
                                  <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Agent Name Clickable To Redirect to Agent Profile</h5>
                                  <h5> <span class="label label-warning">Fix</span> </h5>
                                  <h5><small><span class="fa fa-circle text-warning m-r-5"></small></span>All Statuses Results In The Dashboard</h5>
                                  <h5> <span class="label label-danger">Remove</span> </h5>
                                  <h5><small><span class="fa fa-circle text-danger m-r-5"></small></span>Search by Agent Name in The General Search</h5>

                                </div>
                              </div>
                              <div class="m-t-20 m-b-20">
                              </div>
                                  <div class="row">
                                  <div class="col-md-12">
                            <h5><span class="label label-info">v0.4.2</span></h5>

                              <h5> <span class="label label-success">Add</span> </h5>
                              <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Search by Agent Name</h5>
                              <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Agent Name Clickable</h5>
                              <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>User Profile</h5>
                              <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>All Statuses In The Dashboard</h5>
                              <h5><small><span class="fa fa-circle text-success m-r-5"></small></span>Show Ticket Group/Department Name For Users With More Than One Group</h5>
                            </div>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
                </div>

        <!-- Column -->
        <!-- Row -->
        {{-- <div class="row">
          <div class="col-lg-8 col-md-7">
          <div class="card earning-widget">
              <div class="card-header">
                  <div class="card-actions">
                      <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                      <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                      <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                  </div>
                  <h4 class="card-title m-b-0">Activity Overview</h4>
              </div>
              <div class="card-body b-t collapse show">
                  <table class="table v-middle no-border">
                      <tbody>
                        @foreach($activityTickets as $activitylog)
                        <tr>
                            <td>
                              <span class="label label-light-inverse">{{$activitylog->causer->name}}</span>
                              <span class="label label-light-info">{{$activitylog->description}}</span>
                              @isset($activitylog->subject->id)
                                <a href="{{ route('ticket.show',$activitylog->subject->id)}}" title="{{$activitylog->subject->ticket_title}}">{{ str_limit($activitylog->subject->ticket_title, 35)}}</a>
                              @endisset
                              <small class="text-muted">{{$activitylog->created_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
          </div>
        <!-- Column -->
        <div class="col-lg-4 col-md-4">
        <div class="card earning-widget">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                    <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                </div>
                <h4 class="card-title m-b-0">Top Agents</h4>
            </div>
            <div class="card-body b-t collapse show">
                <table class="table v-middle no-border">
                    <tbody>
                      @foreach ($users as $user)
                        <tr>
                            <td style="width:40px">
                              <img src="../assets/images/users/1.jpg" width="50" class="img-circle" alt="logo">
                              {!! Avatar::create($user->name)->setFontSize(14)->setDimension(50, 50)->toSvg(); !!}
                            </td>
                            <td><a href="{{url('/users')}}/{{$user->id}}/edit">{{$user->name}}</a></td>
                            <td align="right"><span class="label label-light-info">
                              {{$user->ticket_count}}
                            </span>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        <!-- Column -->
    </div> --}}
    <!-- Row -->
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

@endsection
