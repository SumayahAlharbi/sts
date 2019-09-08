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
              <label for="name">Location Name</label>
              <input type="text" class="form-control" name="location_name" />
              <small class="form-control-feedback"> example: COMJ - Male </small>
          </div>
          <div class="form-group">
              <label for="name">Location Description</label>
              <input type="text" class="form-control" name="location_description" />
              <small class="form-control-feedback"> example: College of Medicine - Jeddah Male Building </small>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect1">Group</label>
            <select required class="form-control" name="group_id" id="exampleFormControlSelect1">
            <option disabled selected value> Please select group </option>
              @foreach ($groups as $group)
                <option value="{{$group->id}}">{{$group->group_name}}</option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div></div>
@endsection
