@extends('layouts.material')
@section('title', 'Locations')
@section('content')

<div class = 'container'>
  <div class="row">
    @can('create location')
<div class="col">
<a class="btn btn-primary" href="{{ route('location.create')}}" role="button">New +</a>
</div>
@endcan
</div>
<button type="button" class="btn btn-link"></button>
<div class="card uper">
  <div class="card-header">
   All Locations
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
          <td>Location Name</td>
          <td>Location Description</td>
          @if(count($groups) > 1)
            <td>Group</td>
          @endif
          @if(auth()->user()->can('update location'))
          <td>Action</td>
        @endif
        </tr>
    </thead>
    <tbody>
        @foreach($locations as $location)
        <tr>
            <td>{{$location->id}}</td>
            <td>{{$location->location_name}}</td>
            <td>{{$location->location_description}}</td>
            @if(count($groups) > 1)
            <td>
              <small>{{$location->group['group_name']}}</small>
            </td>
             @endif
             @can('update location')
            <td><a href="{{ route('location.edit',$location->id)}}" class="btn btn-primary">Edit</a></td>
          @endcan

        @can('delete location')
            <td>
                <form onsubmit="return confirm('Do you really want to delete?');" action="{{ route('location.destroy', $location->id)}}" method="post">
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
{{ $locations->onEachSide(1)->links() }}
  </div>
  </div>
</div></div>
@endsection
