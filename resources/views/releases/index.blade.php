@extends('layouts.material')
@section('title', 'Statuses')
@section('content')

<div class = 'container'>
  <div class="row">
<div class="col">
<a class="btn btn-primary" href="{{ route('releases.create')}}" role="button">New +</a>
</div>
</div>
<button type="button" class="btn btn-link"></button>
<div class="card uper">
  <div class="card-header">
   All Release
  </div>
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
  <table class="table">
    <thead>
        <tr>
          <td>ID</td>
          <td>Release Version</td>
          <td>Release Description</td>
        </tr>
    </thead>
    <tbody>
        @foreach($releases as $release)
        <tr>
            <td>{{$release->id}}</td>
            <td>{{$release->release_version}}</td>
            <td>{{$release->release_description}}</td>
            <td><a href="{{ route('releases.edit',$release->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('releases.destroy', $release->id)}}" method="post">
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
