@extends('layouts.app')

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
   All Location
  </div>
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Location Name</td>
          <td>Location desc</td>
          <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($locations as $location)
        <tr>
            <td>{{$location->id}}</td>
            <td>{{$location->location_name}}</td>
            <td>{{$location->location_description}}</td>
            <td><a href="{{ route('location.edit',$location->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('location.destroy', $location->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div></div>
@endsection
