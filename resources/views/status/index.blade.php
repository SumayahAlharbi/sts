@extends('layouts.material')
@section('title', 'Statuses')
@section('content')

<div class = 'container'>
  <div class="row">
<div class="col">
<a class="btn btn-primary" href="{{ route('status.create')}}" role="button">New +</a>
</div>
</div>
<button type="button" class="btn btn-link"></button>
<div class="card uper">
  <div class="card-header">
   All status
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
          <td>status Name</td>
          <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($statuses as $status)
        <tr>
            <td>{{$status->id}}</td>
            <td>{{$status->status_name}}</td>
            <td><a href="{{ route('status.edit',$status->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('status.destroy', $status->id)}}" method="post">
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
