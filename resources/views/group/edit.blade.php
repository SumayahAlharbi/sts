@extends('layouts.material')
@section('title', 'Edit: ' . $group->group_name  ) 
@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Edit group
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
      <form method="post" action="{{ route('group.update', $group->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">group name</label>
          <input type="text" class="form-control" name="group_name" value="{{ $group->group_name }}" />
        </div>

        <div class="form-group">
          <label for="price">group description</label>
          <input type="text" class="form-control" name="group_description" value="{{ $group->group_description }}" />
        </div>
        
        <div class="form-group">
              <label for="price">group email</label>
              <input type="email" class="form-control" name="email" value="{{ $group->email}}"/>
          </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">Regions</label>
          <select required class="form-control" name="region_id">
            @foreach ($regions as $region)
            @if ($region->id == $group->region_id)
           <option selected value="{{$region->id}}">{{$group->region->name}}</option>
           @else
           <option value="{{$region->id}}">{{$region->name}}</option>
           @endif
            @endforeach
          </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect1">Available to Enduser?</label>
            <div class="switch">
                <label>
                  OFF
                  {{-- <input type="checkbox" checked=""> --}}
                  <input data-id="{{$group->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $group->visibility_id  == 1 ? 'checked' : '' }}>
                  <span class="lever switch-col-light-green"></span>
                  ON
                </label>
        </div>
      </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
</div>
<script>
    $(function() {
      $('.toggle-class').change(function() {
          var visibility_id = $(this).prop('checked') == true ? 1 : 0;
          var group_id = $(this).data('id'); 
           
          $.ajax({
              type: "GET",
              dataType: "json",
              url: '{{ route('group.change.visibility') }}',
              data: {'visibility_id': visibility_id, 'group_id': group_id},
            success: function (data) {
                // console.log(data.message);
            }
          });
      })
    })
  </script>
@endsection
