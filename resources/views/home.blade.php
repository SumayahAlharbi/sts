@extends('layouts.material')
@section('title', 'Dashboard')
@section('content')

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
                                <li>
                                    <h6 class="text-muted text-warning"><span class="label label-warning">Pending {{$ticketsStats->where('status_id','=','4')->count()}}</span></h6></li>
                                <li>
                                    <h6 class="text-muted text-info"><span class="label label-inverse"> In Progress {{$ticketsStats->where('status_id','=','5')->count()}}</span></h6></li>
                                <li>
                                    <h6 class="text-muted text-info"><span class="label label-inverse"> Scheduled {{$ticketsStats->where('status_id','=','2')->count()}}</span></h6> </li>
                                <li>
                                    <h6 class="text-muted  text-success"><span class="label label-success"> Completed {{$ticketsStats->where('status_id','=','1')->count()}}</span> </h6> </li>
                                <li>
                                    <h6 class="text-muted  text-danger"><span class="label label-danger"> Unassigned {{$ticketsStats->where('status_id','=','3')->count()}}</span> </h6> </li>
                            </ul>
                        </div>
                    </div>
             </div>

    </div>

                <div class="row">
                  <div class="col-md-12">
                  <div class="card">

                      <div class="card-body">
                            <a class="btn text-muted" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="far fa-caret-square-down"></i>  Releases <span class="label label-warning">New</span>
                            </a>
                            <div class="collapse" id="collapseExample">
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
