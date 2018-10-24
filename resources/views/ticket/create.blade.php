@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Add new Ticket
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
              <label for="name">ticket title</label>
              <input type="text" class="form-control" name="ticket_title"/>
          </div>
          <div class="form-group">
              <label for="price">ticket content</label>
              {{-- <input type="text" class="form-control" name="ticket_content"/> --}}
              <textarea name="ticket_content" class="form-control" id="editor" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Example select</label>
            <select class="form-control" name="category_id" id="exampleFormControlSelect1">
              @foreach ($categories as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Example select</label>
            <select class="form-control" name="category_id" id="exampleFormControlSelect1">
              @foreach ($categories as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div></div>
@endsection
