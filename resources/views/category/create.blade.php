@extends('layouts.material')
@section('title', 'Create Category')
@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Add new category
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
      <form method="post" action="{{ route('category.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">category name</label>
              <input type="text" class="form-control" name="category_name"/>
          </div>

          <div class="form-group">
            <label for="exampleFormControlSelect1">Group</label>
            <select required class="form-control" name="group_id" id="exampleFormControlSelect1">
              @foreach ($groups as $group)
                <option value="{{$group->id}}">{{$group->group_name}}</option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div></div>
@endsection
