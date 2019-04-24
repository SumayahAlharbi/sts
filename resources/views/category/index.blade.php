@extends('layouts.material')
@section('title', 'Categories')
@section('content')

<div class = 'container'>
  <div class="row">
    @can('create category')
<div class="col">
<a class="btn btn-primary" href="{{ route('category.create')}}" role="button">New +</a>
</div>
@endcan
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
  <table class="table">
    <thead>
        <tr>
          <td>ID</td>
          <td>Category Name</td>
          @if(count($groups) > 1)
            <td>Group</td>
          @endif
          @if(auth()->user()->can('update category'))
          <td>Action</td>
        @endif
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->category_name}}</td>
            @if(count($groups) > 1)
            <td>
              <small>{{$category->group['group_name']}}</small>
            </td>
             @endif
             @can('update category')
            <td><a href="{{ route('category.edit',$category->id)}}" class="btn btn-primary">Edit</a></td>
          @endcan
          @can('delete category')
            <td>
                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('category.destroy', $category->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
          @endcan
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <div class="text-right">
                    <ul class="pagination pagination-centered hide-if-no-paging"> </ul>
                </div>
            </td>
        </tr>
    </tfoot>
  </table>
  <div class="row">
    <div class="col-md-12">
  {{ $categories->onEachSide(1)->links() }}
  </div>
  </div>
  </div></div>
  @endsection
