@extends('layouts.material')

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Edit status
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
      <form method="post" action="{{ route('status.update', $status->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">status_name</label>
          <input type="text" class="form-control" name="status_name" value="{{ $status->status_name }}" />
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>
@endsection
