@extends('layouts.app')

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Edit Ticket
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('ticket.update', $ticket->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">Ticket Title:</label>
          <input type="text" class="form-control" name="ticket_title" value={{ $ticket->ticket_title }} />
        </div>
        <div class="form-group">
          <label for="price">Ticket content:</label>
          <input type="text" class="form-control" name="ticket_content" value={{ $ticket->ticket_content }} />
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>
@endsection
