@extends('layouts.material')

@section('content')

<div class = 'container'>
  <div class="row">
<div class="col">
<a class="btn btn-primary" href="{{ route('permissions.create')}}" role="button">New +</a>
</div>
</div>
<button type="button" class="btn btn-link"></button>
<div class="card uper">
  <div class="card-header">
   All Permissions
  </div>
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
	<table class="table table-striped">
		<head>
			<th>Permission</th>
			<th>Actions</th>
		</head>
		<tbody>
			@foreach($permissions as $permission)
			<tr>
				<td>{{$permission->name}}</td>
				<td>
				@if(!empty($permission->permissions))
					@foreach($permission->permissions as $permission)
					<small class = 'label bg-orange'>{{$permission->name}}</small>
					@endforeach
				@endif
				</td>
				<td>
					<a href="{{url('/permissions')}}/{{$permission->id}}/{{('edit')}}" class = "btn btn-primary">edit</a>
					<a href="{{url('/permissions/delete')}}/{{$permission->id}}" class = "btn btn-danger">X</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div></div>
@endsection
