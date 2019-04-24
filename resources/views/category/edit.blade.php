@extends('layouts.material')
@section('title', 'Edit: ' . $category->category_name)
@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Edit category
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
      <form method="post" action="{{ route('category.update', $category->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">category name</label>
          <input type="text" class="form-control" name="category_name" value="{{ $category->category_name }}" />
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">Group</label>
          <select required class="form-control" name="group_id" id="exampleFormControlSelect1">
            @foreach ($groups as $group)
              @if ($group->id == $category->group_id)
           <option selected value="{{$group->id}}">{{$group->group_name}}</option>
           @else
           <option value="{{$group->id}}">{{$group->group_name}}</option>
           @endif
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>
@endsection
