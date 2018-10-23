@extends('layouts.app')

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Edit location
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
      <form method="post" action="{{ route('location.update', $location->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">location_name</label>
          <input type="text" class="form-control" name="location_name" value={{ $location->location_name }} />
        </div>
        <div class="form-group">
          <label for="name">location_description </label>
          <input type="text" class="form-control" name="location_description" value={{ $location->location_description }} />
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>
@endsection
