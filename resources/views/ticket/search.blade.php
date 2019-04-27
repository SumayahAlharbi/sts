@extends('layouts.material')
@section('title', 'Search')

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
                <h4 class="card-title">Search Results</h4>
                <div class="row">
                  <div class="col-lg-9">

                  </div>

                                                {{-- <div class="col-lg-3 content-right">
                                                  <form method="get" action="{{ route('ticket.search') }}"><div class="input-group footable-filtering-search">
                                                    <label class="sr-only">Search</label>
                                                    <div class="input-group">
                                                      <input type="text" name="searchKey" class="form-control" placeholder="Search">
                                                      <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary">
                                                          <span class="fas fa-search"></span></button>

                                                              </div>
                                                            </div>
                                                          </div>
                                                        </form>
                                                </div> --}}
                </div>
<table class="footable table m-b-0 toggle-circle" data-filter="#filter" data-filter-text-only="true">
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
      @foreach($findTickets as $ticket)
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
              <small>{{$ticket->group->group_name}}</small>
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
                {{-- {{ $findTickets->onEachSide(1)->links() }} --}}
                {{$findTickets->appends(request()->query())->links()}}
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
