@extends('layouts.material')
@section('title', 'Categories')
@section('content')

<div class = 'container'>
  <div class="row">
<div class="col">
<a class="btn btn-primary" href="{{ route('category.create')}}" role="button">New +</a>
</div>
</div>
<button type="button" class="btn btn-link"></button>
<div class="card uper">
  <div class="card-header">
   All Categories
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
          <td>Category Name</td>
          <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->category_name}}</td>
            <td><a href="{{ route('category.edit',$category->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('category.destroy', $category->id)}}" method="post">
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
