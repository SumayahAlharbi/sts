@extends('layouts.material')
@section('title', 'Create Release')
@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Add new Release
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
      <form method="post" action="{{ route('releases.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">Release Version</label>
              <input type="text" class="form-control" name="release_version"/>

              <label for="name">Release Description</label>
              <input type="text" class="form-control" name="release_description"/>
              
          </div>

          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div></div>
@endsection