@extends('layouts.material')
@section('title', 'Create Status')
@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Add new status
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
      <form method="post" action="{{ route('status.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">status name</label>
              <input type="text" class="form-control" name="status_name" required/>
          </div>

          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div></div>
@endsection
