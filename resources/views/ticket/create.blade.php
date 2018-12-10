@extends('layouts.material')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

<div class = 'row'>
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">
    + New Ticket
    </h4>

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
      <form method="post" action="{{ route('ticket.store') }}">
        <div class="row p-t-20">
          <div class="form-group col-md-6">
              @csrf
              <label for="name">Ticket Title</label>
              <input type="text" class="form-control" name="ticket_title" required/>
          </div>
          <div class="form-group col-md-6">
            <label class="control-label">Priority</label>
            <select class="form-control custom-select" name="priority" data-placeholder="Choose a Priority Level" tabindex="1">
                  <option value="Low">Low</option>
                  <option value="Medium">Medium</option>
                  <option value="High">High</option>
                  <option value="Critical">Critical</option>
            </select>
          </div>
        </div>
          <div class="form-group">
              <label for="ticket_content">Ticket Content</label>
              <textarea name="ticket_content" class="form-control" id="editor" rows="3" required></textarea>
          </div>
          <div class="row p-t-20">
          <div class="col-md-4">
          <div class="form-group">
            <label for="exampleFormControlSelect1">Category</label>
            <select class="form-control" name="category_id" id="exampleFormControlSelect1">
              @foreach ($categories as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="exampleFormControlSelect1">Location</label>
            <select class="form-control" name="location_id" id="exampleFormControlSelect1">
              @foreach ($locations as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group col-md-4">
          <label for="name">Room Number</label>
          <input type="text" class="form-control" name="room_number"/>
        </div>
      </div>
      <div class="row p-t-20">
      <div class="col-md-4">
        <div class="form-group">
          <label for="exampleFormControlSelect1">Group</label>
          <select required class="form-control" name="group_id" id="exampleFormControlSelect1">
            @foreach ($groups as $group)
              <option value="{{$group->id}}">{{$group->group_name}}</option>
            @endforeach
          </select>
        </div>
      </div>

        {{-- <div class="col-md-4">
          <div class="form-group">
            <label for="exampleFormControlSelect1">Requested by</label>
            <select class="form-control" name="requested_by" id="exampleFormControlSelect1">
              @foreach ($users as $key => $value)
                @if ($key == $created_by->id)
                <option selected value="{{$key}}">(Current) {{$value}}</option>
                @else
                <option value="{{$key}}">{{$value}}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div> --}}

<div class="col-md-4">
  <div class="form-group">
    <label for="exampleFormControlSelect1">Requested by</label>
  <select class="selectpicker form-control" name="requested_by" data-show-subtext="true" data-live-search="true">
    @foreach ($users as $key => $value)
      @if ($key == $created_by->id)
      <option selected value="{{$key}}">(Current) {{$value}}</option>
      @else
      <option value="{{$key}}">{{$value}}</option>
      @endif
    @endforeach
  </select>
</div>
</div>


      </div>
          <div class="form-group">
              <input type="text" class="form-control" name="created_by" value="{{$created_by->id}}" hidden />
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div></div>
@endsection
