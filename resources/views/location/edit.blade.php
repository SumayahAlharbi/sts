@extends('layouts.material')
@section('title', 'Edit: ' . $location->location_name)
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
          <label for="name">Location Name</label>
          <input type="text" class="form-control" name="location_name" value="{{ $location->location_name }}" />
        </div>
        <div class="form-group">
          <label for="name">Location Description </label>
          <input type="text" class="form-control" name="location_description" value="{{ $location->location_description }}" />
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">Group</label>
          <select required class="form-control" name="group_id" id="exampleFormControlSelect1">
            @foreach ($groups as $group)
              @if ($group->id == $location->group_id)
           <option selected value="{{$group->id}}">{{$group->group_name}}</option>
           @else
           <option value="{{$group->id}}">{{$group->group_name}}</option>
           @endif
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>
@endsection
