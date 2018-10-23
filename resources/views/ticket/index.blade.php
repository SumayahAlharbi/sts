@extends('layouts.app')

@section('content')

<div class = 'container'>
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
          <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
        <tr>
            <td>{{$ticket->id}}</td>
            <td>{{$ticket->ticket_title}}</td>
            <td>{{$ticket->ticket_content}}</td>
            <td><a href="{{ route('ticket.edit',$ticket->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                {{-- <form action="{{ route('shares.destroy', $ticket->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form> --}}
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div></div>
@endsection
