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
        <div class="form-group">
          <label for="price">Ticket Category:</label>
          <input type="text" class="form-control" name="ticket_category" value={{ $ticket->ticket_content }} />
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">location</label>
          <select class="form-control" name="location_id" id="exampleFormControlSelect1">
            @foreach ($locations as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>
@endsection
