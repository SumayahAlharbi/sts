@extends('layouts.material')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    <div class="card-title">
    + New Ticket
  </div>
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
      <form method="post" action="{{ route('ticket.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">Ticket Title</label>
              <input type="text" class="form-control" name="ticket_title"/>
          </div>
          <div class="form-group">
              <label for="ticket_content">Ticket Content</label>
              <textarea name="ticket_content" class="form-control" id="editor" rows="3"></textarea>
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
        <div class="col-md-4">
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
