@extends('layouts.material')
@section('title', 'Edit: ' . $ticket->ticket_title)

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
        <div class="row p-t-20">
        <div class="form-group col-md-12">
          <label for="name">Ticket Title:</label>
          <input type="text" class="form-control" name="ticket_title" value="{{ $ticket->ticket_title }}"/>
        </div>
      </div>
      <div class="row p-t-20">
        <div class="form-group col-md-6">
          <label class="control-label">Priority</label>
          <select class="form-control custom-select" name="priority" data-placeholder="Choose a Priority Level" tabindex="1">
                <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
                <option value="Critical" {{ $ticket->priority == 'Critical' ? 'selected' : '' }}>Critical</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="name">Due Date</label>
          <input type="text" placeholder="YYYY-MM-DD hh:mm:ss" class="form-control" name="due_date" value="{{ $ticket->due_date }}" id="datetimepicker" readonly />
          {{-- <small class="form-control-feedback"> Date/Time Format: {{ $now }} </small> --}}
        </div>
      </div>
        <div class="form-group">
          <label for="price">Ticket content:</label>
          {{-- <input type="text" class="form-control" name="ticket_content" value="{{ $ticket->ticket_content }}" /> --}}
          <textarea name="ticket_content" class="form-control" id="editor" rows="3">{{ $ticket->ticket_content }}</textarea>

        </div>
        <div class="row">
        <div class="form-group col-md-4">
          <label for="exampleFormControlSelect1">Status</label>
          <select class="form-control" name="status_id" id="exampleFormControlSelect1">
            @foreach ($statuses as $key => $value)
              @if ($key == $ticket->status_id)
           <option selected value="{{$key}}">{{$value}}</option>
           @else
           <option value="{{$key}}">{{$value}}</option>
           @endif
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="exampleFormControlSelect1">Category</label>
          <select class="form-control" name="category_id" id="exampleFormControlSelect1">
            @foreach ($categories as $key => $value)
              @if ($key == $ticket->category_id)
           <option selected value="{{$key}}">{{$value}}</option>
           @else
           <option value="{{$key}}">{{$value}}</option>
           @endif
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="exampleFormControlSelect1">Group</label>
            <select class="form-control" name="group_id" id="exampleFormControlSelect1">
              @foreach ($groups as $group)
                @if ($group->id == $ticket->group_id)
             <option selected value="{{$group->id}}">{{$group->group_name}}</option>
             @else
             <option value="{{$group->id}}">{{$group->group_name}}</option>
             @endif
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-4">
          <label for="exampleFormControlSelect1">Location</label>
          <select class="form-control" name="location_id" id="exampleFormControlSelect1">
            @foreach ($locations as $key => $value)
              @if ($key == $ticket->location_id)
           <option selected value="{{$key}}">{{$value}}</option>
           @else
           <option value="{{$key}}">{{$value}}</option>
           @endif
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="name">Room Number</label>
          <input type="text" class="form-control" name="room_number" value="{{ $ticket->room_number }}"/>
        </div>
        <div class="form-group col-md-4">
          <label for="exampleFormControlSelect1">Requested by</label>
          <select class="selectpicker form-control" name="requested_by"data-show-subtext="true" data-live-search="true"  id="exampleFormControlSelect1" required>
            @foreach($users as $user)
              @if ($user->id == $ticket->requested_by)
           <option selected value="{{$user->id}}">{{$user->name}}</option>
           @else
           <option value="{{$user->id}}">{{$user->name}}</option>
           @endif
            @endforeach
          </select>
        </div>
      </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>


  </div>
</div>
</div>

@endsection
