@extends('layouts.material')

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">

    Edit User {{$user->name}}

   </div>
     <div class="card-body">
   @if(session()->get('success'))
     <div class="alert alert-success">
       {{ session()->get('success') }}
     </div><br />
   @endif
  			<form action="{{ route('users.update', $user->id) }}" method = "post">
          @method('PATCH')
          @csrf
  				<input type="hidden" name = "user_id" value = "{{$user->id}}">

          <div class="form-group">
            <label for="name">KSAU-HS Email</label>
            <input type="text" class="form-control" name="email" value="{{$user->email}}"/>
          </div>

          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{$user->name}}"/>
          </div>

          <div class="form-group">
            <label for="name">Password</label>
            <input type="password" class="form-control" name="password" />
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
  			</form>


<!-- Assign Roles To Users -->

<div class="form-group">
<h5>{{$user->name}} Roles</h5>
</div>



  					<form action="{{url('users/addRole')}}" method = "post">
  						{!! csrf_field() !!}
  						<input type="hidden" name = "user_id" value = "{{$user->id}}">
  						<div class="form-group">
  							<select name="role_name" id="" class = "form-control">

                  @foreach($roles as $role)
                    @if($role != "SuperAdmin")
  								<option value="{{$role}}">{{$role}}</option>
                    @endif
                  @endforeach

  							</select>
  						</div>



  						<div class="form-group">
  							<button class = 'btn btn-primary'>Add role</button>
  						</div>

  					</form>
            <!-- End Assign Roles To Users -->

            <div class="form-group">
            @foreach($userRoles as $role)
              @if($role->name != "SuperAdmin")
            <a class='btn btn-primary' href='{{url('users/removeRole')}}/{{str_slug($role->name,'-')}}/{{$user->id}}' data-activates='goal-assign'><i class="material-icons left">cancel</i>{{$role->name}}</a>
              @endif
            @endforeach
          </div>

          <div class="form-group">
          <h5>Add user to groups</h5>
          </div>

            <form action="{{url('users/addUserGroup')}}" method = "post">

              @csrf
                                    <input type="hidden" name = "user_id" value = "{{$user->id}}">
                                    <div class="form-group">
                                        <select name="group_id" id="" class = "form-control">
                                            @foreach($groups as $group)
                                            <option value="{{$group->id}}">{{$group->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    <button class='btn btn-primary'>Assign</button>
                                    </div>
                                </form>

                                <div class="form-group">
                                @foreach($userGroups as $userGroup)
                                  <a class='btn btn-primary' href='{{url('users/removeUserGroup')}}/{{$userGroup->id}}/{{$user->id}}' data-activates=''>{{$userGroup->group_name}}  <i class="icon ion-md-close"></i></a>
                                @endforeach
                              </div>



  			</div>
  		</div>

  	</div>
    </div>

@endsection
