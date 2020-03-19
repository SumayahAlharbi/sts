@extends('layouts.material')
@section('title', 'Edit: ' . $releases->id)
@section('content')

<script src="/vendor/ckeditor/ckeditor.js"></script>

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Edit release
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
      <form method="post" action="{{ route('releases.update', $releases->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">release_version</label>
          <input type="text" class="form-control" name="release_version" value="{{ $releases->release_version }}" />
          <label for="name">release_description</label>
          <textarea name="release_description" class="form-control" id="editor" rows="3">{{ $releases->release_description }}</textarea>
          <script>
              CKEDITOR.replace( 'editor' );
        </script>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>
@endsection
