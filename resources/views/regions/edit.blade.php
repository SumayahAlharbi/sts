@extends('layouts.material')
@section('title', 'Edit: ' . $region->name)
@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Edit region
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
      <form method="post" action="{{ route('regions.update', $region->id) }}">
        @method('PATCH')
        @csrf
         <div class="form-group">
              <label for="name">region name:</label>
              <input type="text" class="form-control" name="name" value="{{ $region->name }}" />
           </div>
          
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
@endsection
