@extends('layouts.app')

@section('content')

<div class = 'container'>
  <a href="{{ route('ticket.create')}}" class="btn btn-primary">New +</a>
<div class="card uper">
  <div class="card-header">
   All tickets
  </div>
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>ticket title</td>
          <td>ticket content</td>
          <td>ticket category</td>
          <td>ticket location</td>
          <td>ticket assignee</td>
          <td>ticket status</td>
          <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
        <tr>
            <td>{{$ticket->id}}</td>
            <td>{{$ticket->ticket_title}}</td>
            <td>{{$ticket->ticket_content}}</td>
            <td>{{$ticket->category['category_name']}}</td>
            <td>{{$ticket->location['location_name']}}</td>
            <td>
              @foreach($ticket->user as $ticket_assignee)
                {{$ticket_assignee->name}}
              @endforeach
            </td>
            <td>{{$ticket->status['status_name']}}</td>
            <td>
              <a href="{{ route('ticket.edit',$ticket->id)}}" class="btn btn-primary">Edit</a>
              <a href="{{ route('ticket.show',$ticket->id)}}" class="btn btn-primary">Show</a>
            </td>
            <td>
                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('ticket.destroy', $ticket->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div></div>
@endsection
