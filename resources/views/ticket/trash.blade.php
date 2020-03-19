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
                <h4 class="card-title">Deleted Ticket List</h4>
                {{-- <h6 class="card-subtitle">List of ticket</h6> --}}


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
                          <td>{{ str_limit($ticket->ticket_title, 35)}}</a>
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
                            <span class="label
                            @if ($ticket->status['status_name'] == 'Unassigned') label-danger
                            @elseif ($ticket->status['status_name'] == 'Completed') label-success
                            @elseif ($ticket->status['status_name'] == 'Pending') label-warning
                            @elseif ($ticket->status['status_name'] == 'In Progress') label-primary
                            @else label-inverse
                            @endif">
                            {{$ticket->status['status_name']}}
                          </span>
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
                          @can('restore ticket')
                          <td>
                              <a href="{{ route('ticket.restore',$ticket->id)}}" title="restore" class="btn btn-success"><i class="fa fa-recycle"></i></a>

                          </td>
                          @endcan

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
