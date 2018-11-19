@extends('layouts.app')

@section('content')

<div class = 'container'>
  @role('admin')
<div class="row">
<div class="col">
<a class="btn btn-primary" href="{{ route('ticket.create')}}" role="button">New  <i class="icon ion-md-add-circle"></i></a>
</div>
</div>
@endrole

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


<div class="row mt-2">
<div class="col">
<div class="card uper">
  <div class="card-header">
   All tickets

  </div>

  <table class="table table-striped">
    <thead>
        <tr>
          {{-- <td>ID</td> --}}
          <td>Ticket</td>
          {{-- <td>ticket content</td> --}}
          <td>Category</td>
          <td>Location</td>
          <td>Agents</td>
          <td>Status</td>
          @role('admin')
          <td>Action</td>
          @endrole
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
        <tr>
            {{-- <td>{{$ticket->id}}</td> --}}
            <td><h4><small class="text-muted">#{{$ticket->id}} </small> <a href="{{ route('ticket.show',$ticket->id)}}"> {{ str_limit($ticket->ticket_title, 35)}}</a> <small class="text-muted"> ({{$ticket->comments()->count()}})</small></h4></td>
            {{-- <td>{{$ticket->ticket_content}}</td> --}}
            <td>{{$ticket->category['category_name']}}</td>
            <td>{{$ticket->location['location_name']}}</td>
            <td>
              @foreach($ticket->user as $ticket_assignee)
                {{$ticket_assignee->name}}
              @endforeach
            </td>
            <td>{{$ticket->status['status_name']}}</td>
            <td>

            {{-- </td>
            <td> --}}
            @role('admin')
                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <a href="{{ route('ticket.edit',$ticket->id)}}" class="btn btn-primary"><i class="icon ion-md-create"></i></a>
                  <a href="{{ route('ticket.show',$ticket->id)}}" class="btn btn-primary"><i class="icon ion-md-eye"></i></a>
                  <button class="btn btn-danger" type="submit"><i class="icon ion-md-trash"></i></button>
                </form>
                @endrole
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
{!! $tickets->links() !!}
</div>
</div>
</div>
@endsection
