@extends('layouts.material')
@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4 col-xlg-3 col-md-5">
      <div class="card">
        <div class="card-body">
          <center class="m-t-30">
            {!! Avatar::create($user->name)->setFontSize(30)->setDimension(150, 150)->toSvg(); !!}
            <h4 class="card-title m-t-10">{{$user->name}}</h4>
            <h6 class="card-subtitle">{{$user->email}}</h6>
            <div class="row text-center justify-content-md-center">
              @if(count($user->group) > 0)
              @foreach($user->group as $group)
              <span class="label label-light-inverse">{{$group->group_name}}</span>
              @endforeach
              @endif
            </div>
            <div class="row text-center justify-content-md-center m-t-5">
              <i class="fab fa-stack-overflow"> {{count($assigned_tickets)}}</i>
            </div>
          </center>
        </div>
      </div>
    </div>
    <div class="col-lg-8 col-xlg-9 col-md-7">
      <div class="card">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs profile-tab" role="tablist">
          <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tickets" role="tab">Tickets</a> </li>
          {{-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#activity" role="tab">Activity</a> </li> --}}
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="tickets" role="tabpanel">
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
                    <td><a href="{{ route('ticket.show',$ticket->id)}}" title="{{$ticket->ticket_title}}"> {{ str_limit($ticket->ticket_title, 35)}}</a> <small class="text-muted"> ({{$ticket->comments()->count()}})<br> {{$ticket->created_at->diffForHumans()}}</small></td>
                    <td>{{ str_limit($ticket->ticket_title, 35)}} <small class="text-muted"> ({{$ticket->comments()->count()}})<br> {{$ticket->created_at->diffForHumans()}}</small></td>

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

@endsection
