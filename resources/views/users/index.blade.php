@extends('layouts.app')

@section('content')

<div class = 'container'>
  <div class="row">
<div class="col">
<a class="btn btn-primary" href="" role="button">New  <i class="icon ion-md-add-circle"></i></a>
</div>
</div>
<button type="button" class="btn btn-link"></button>

<div class="card uper">
  <div class="card-header">
   All users

  </div>
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif

  <table class="table table-striped">
    <thead>
        <tr>
          <td>User</td>
          <td>Actions</td>
        </tr>
    </thead>
    <tbody>

  @foreach($users as $user)
    <tr>

    <td><a href="{{url('/users')}}/{{$user->id}}/edit" class="collection-item">{{$user->name}}</a></td>
    <td>

        @if(!empty($user->roles))
        @foreach($user->roles as $role)

        <span class="new badge" data-badge-caption="">
          {{$role->name}}
        </span>

        @endforeach
        @else
        <span class="new badge grey" data-badge-caption="">
          No Roles
        </span>
        @endif
    </td>
  </tr>
    @endforeach

  </tbody>
  </table>

</div>
{{-- {!! $users->render() !!} --}}
</div>
@endsection
