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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Support Ticket List</h4>
                <h6 class="card-subtitle">List of ticket</h6>
                <div class="row m-t-40">
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-info">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white">{{$ticketsStats->count()}}</h1>
                                <h6 class="text-white">Total Tickets</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-success card-success">
                            <div class="box text-center">
                                <h1 class="font-light text-white">{{$ticketsStats->where('status_id','=','1')->count()}}</h1>
                                <h6 class="text-white">Completed</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-danger card-danger">
                            <div class="box text-center">
                                <h1 class="font-light text-white">{{$ticketsStats->where('status_id','=','3')->count()}}</h1>
                                <h6 class="text-white">Unassigned</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-warning card-warning">
                            <div class="box text-center">
                                <h1 class="font-light text-white">{{$ticketsStats->where('status_id','=','4')->count()}}</h1>
                                <h6 class="text-white">Pending</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    @can('create ticket')
                      <a class="btn btn-primary" href="{{ route('ticket.create')}}" title="Create New Ticket" role="button"><i class="fa fa-plus-circle"></i> New</a>
                    @endcan
                  </div>
                </div>



              <table class="footable table m-b-0 toggle-circle" data-sort="false">
                  <thead>



                      <tr>
                          <th> # </th>
                          <th data-hide="phone,tablet" data-ignore="true"> Title </th>
                          <th data-hide="desktop,xdesktop" data-ignore="true"> Title </th>
                          <th> Status </th>

                          <th data-hide="phone">Category</th>
                          <th data-hide="phone">Agents</th>
                          <th data-hide="all">Requested by</th>
                          <th data-hide="all">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($tickets as $ticket)
                      <tr>
                          <td>{{$ticket->id}}</td>
                          <td><a href="{{ route('ticket.show',$ticket->id)}}"> {{ str_limit($ticket->ticket_title, 35)}}</a> <small class="text-muted"> ({{$ticket->comments()->count()}})<br> {{$ticket->created_at->diffForHumans()}}</small></td>
                          <td>{{ str_limit($ticket->ticket_title, 35)}} <small class="text-muted"> ({{$ticket->comments()->count()}})<br> {{$ticket->created_at->diffForHumans()}}</small></td>

                          <td title="{{$ticket->status['status_name']}}">
                            {{-- @if(auth()->user()->can('change ticket status'))
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



                          @else --}}
                            <span class="label
                            @if ($ticket->status['status_name'] == 'Unassigned') label-danger
                            @elseif ($ticket->status['status_name'] == 'Completed') label-success
                            @elseif ($ticket->status['status_name'] == 'Pending') label-warning
                            @else label-inverse
                            @endif">
                            {{$ticket->status['status_name']}}
                          </span>
                          {{-- @endif --}}
                          </td>
                          <td>{{$ticket->category['category_name']}}</td>
                          <td>
                          @foreach($ticket->user as $ticket_assignee)
                          <span class="label label-table label-success">{{$ticket_assignee->name}}</span>
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

@endsection
