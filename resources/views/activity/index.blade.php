@extends('layouts.material')
@section('title', 'Activity')
@section('content')

<div class = 'container'>

<button type="button" class="btn btn-link"></button>


<div class="row">

<div class="col-lg-6">

<div class="card">

  <div class="card-body">
      <div class="card-header">
   Ticket Activity
  </div>

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif

  <table class="table table-striped">

    <tbody>
        @foreach($activityTickets as $activitylog)
        <tr>
            <td>{{$activitylog->id}}</td>
            <td>
              <span class="label label-light-inverse">{{$activitylog->causer->name}}</span>
              <span class="label label-light-info">{{$activitylog->description}}</span>
              <a href="{{ route('ticket.show',$activitylog->subject->id)}}">{{ str_limit($activitylog->subject->ticket_title, 35)}}</a>
              <small class="text-muted">{{$activitylog->created_at->diffForHumans()}}</small>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <div class="text-right">
                    <ul> {{ $activityTickets->links() }} </ul>
                </div>
            </td>
        </tr>
    </tfoot>
  </table>
    </div>
</div>
</div>

{{-- user activity --}}

<div class="col-lg-6">

<div class="card">

  <div class="card-body">
      <div class="card-header">
   User Activity
  </div>

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif

  <table class="table table-striped">

    <tbody>
        @foreach($activityUsers as $activityUser)
        <tr>
            <td>{{$activityUser->id}}</td>
            <td>
              <span class="label label-light-inverse">{{$activityUser->causer->name}}</span>
              <span class="label label-light-info">{{$activityUser->description}}</span>
              <a href="{{ route('users.edit',$activityUser->subject->id)}}">{{ str_limit($activityUser->subject->name, 35)}}</a>
              <small class="text-muted">{{$activityUser->created_at->diffForHumans()}}</small>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <div class="text-right">
                    <ul> {{ $activityUsers->links() }} </ul>
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
@endsection
