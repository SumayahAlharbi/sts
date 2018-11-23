@extends('layouts.material')

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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Support Ticket List</h4>
                <h6 class="card-subtitle">List of ticket</h6>
                <div class="row m-t-40">
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-info">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white">{{$tickets->count()}}</h1>
                                <h6 class="text-white">Total Tickets</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-primary card-inverse">
                            <div class="box text-center">
                                <h1 class="font-light text-white">{{$tickets->where('status_id','=','1')->count()}}</h1>
                                <h6 class="text-white">Completed</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-success">
                            <div class="box text-center">
                                <h1 class="font-light text-white">{{$tickets->where('status_id','=','3')->count()}}</h1>
                                <h6 class="text-white">Unassigned</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-dark">
                            <div class="box text-center">
                                <h1 class="font-light text-white">{{$tickets->where('status_id','=','4')->count()}}</h1>
                                <h6 class="text-white">Pending</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <a class="btn btn-primary" href="{{ route('ticket.create')}}" role="button"><i class="fa fa-plus-circle"></i> New</a>


                <div class="table-responsive">
                    <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list" data-page-size="10">
                        <thead>
                            <tr>
                                <th>ID #</th>
                                <th>Title</th>
                                <th>Created By</th>
                                <th>Category</th>
                                <th>Agents</th>
                                <th>Status</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($tickets as $ticket)
                            <tr>
                                <td>{{$ticket->id}}</td>
                                <td><a href="{{ route('ticket.show',$ticket->id)}}"> {{ str_limit($ticket->ticket_title, 35)}}</a> <small class="text-muted"> ({{$ticket->comments()->count()}})</small></td>
                                <td>
                                    <a href="javascript:void(0)"><img src="{{$ticket->created_by_user->gravatar}}" alt="user" class="img-circle" /> {{$ticket->created_by_user->name}}</a>
                                </td>
                                <td>{{$ticket->category['category_name']}}</td>
                                <td>
                                  @foreach($ticket->user as $ticket_assignee)
                                    {{$ticket_assignee->name}} <br>
                                  @endforeach
                                </td>
                                <td>{{$ticket->status['status_name']}}</td>
                                {{-- <td>
                                  <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('ticket.edit',$ticket->id)}}" class="btn btn-primary"><i class="icon ion-md-create"></i></a>
                                    <a href="{{ route('ticket.show',$ticket->id)}}" class="btn btn-primary"><i class="icon ion-md-eye"></i></a>
                                    <button class="btn btn-danger" type="submit"><i class="icon ion-md-trash"></i></button>
                                  </form>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="text-right">
                                        <ul class="pagination"> </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- old table --}}


{{-- <div class="row mt-2">
<div class="col">
<div class="card uper">
  <div class="card-header">
   All tickets

  </div>

  <table class="table table-striped">
    <thead>
        <tr>

          <td>Ticket</td>
          <td>Category</td>
          <td>Location</td>
          <td>Agents</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
        <tr>
            <td><h4><small class="text-muted">#{{$ticket->id}} </small> <a href="{{ route('ticket.show',$ticket->id)}}"> {{ str_limit($ticket->ticket_title, 35)}}</a> <small class="text-muted"> ({{$ticket->comments()->count()}})</small></h4></td>
            <td>{{$ticket->category['category_name']}}</td>
            <td>{{$ticket->location['location_name']}}</td>
            <td>
              @foreach($ticket->user as $ticket_assignee)
                {{$ticket_assignee->name}}
              @endforeach
            </td>
            <td>{{$ticket->status['status_name']}}</td>
            <td>


                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <a href="{{ route('ticket.edit',$ticket->id)}}" class="btn btn-primary"><i class="icon ion-md-create"></i></a>
                  <a href="{{ route('ticket.show',$ticket->id)}}" class="btn btn-primary"><i class="icon ion-md-eye"></i></a>
                  <button class="btn btn-danger" type="submit"><i class="icon ion-md-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
{!! $tickets->links() !!}
</div>
</div>
</div> --}}
@endsection
