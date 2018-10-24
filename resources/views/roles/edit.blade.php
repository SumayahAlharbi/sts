@hasrole('Admin')
@extends('scaffold-interface.layouts.app')
@section('content')
<section class="content">
	<div class="box box-primary">
		<div class="box-header">
			<h3>Edit Role</h3>
		</div>
		<div class="box-body">
			<form action="{{url('scaffold-roles/update')}}" method = "post">
				{!! csrf_field() !!}
				<input type="hidden" name = "role_id" value = "{{$role->id}}">
				<div class="form-group">
				<label for="">Role</label>
					<input type="text" name = "name" class = "form-control" placeholder = "Name" value = "{{$role->name}}">
				</div>
				<div class="box-footer">
					<button class = 'btn btn-primary' type = "submit">Update</button>
				</div>
			</form>
		</div>
	</div>
			<div class="box box-primary">
				<div class="box-header">
					<h3>{{$role->name}} Permissions</h3>
				</div>
				<div class="box-body">
					<form action="{{url('scaffold-roles/addPermission')}}" method = "post">
						{!! csrf_field() !!}
						<input type="hidden" name = "role_id" value = "{{$role->id}}">
						<div class="form-group">
							<select name="permission_name" id="" class = "form-control">
								@foreach($permissions as $permission)
								<option value="{{$permission}}">{{$permission}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<button class = 'btn btn-primary'>Add permission</button>
						</div>
					</form>
					<table class = 'table'>
						<thead>
							<th>Permission</th>
							<th>Action</th>
						</thead>
						<tbody>
							@foreach($RolePermissions as $permission)
							<tr>
								<td>{{$permission->name}}</td>
								<td><a href="{{url('scaffold-roles/removePermission')}}/{{str_slug($permission->name,'-')}}/{{$role->id}}" class = "btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
</section>
@endsection
@endhasrole
