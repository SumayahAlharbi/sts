@extends('layouts.material')
@section('title', 'Create Location')
@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Add new location
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
      <form method="post" action="{{ route('location.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">location name</label>
              <input type="text" class="form-control" name="location_name"/>
          </div>
          <div class="form-group">
              <label for="name">location description</label>
              <input type="text" class="form-control" name="location_description"/>
          </div>

          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div></div>
@endsection
