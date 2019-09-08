@extends('layouts.material')
@section('title', 'Create Region')
@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Add Region
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
      <form method="post" action="{{ route('regions.store') }}">
          <div class="form-region">
              @csrf
              <label for="name">region name</label>
              <input type="text" class="form-control" name="name"/>
          </div>
          <br>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div></div>
@endsection