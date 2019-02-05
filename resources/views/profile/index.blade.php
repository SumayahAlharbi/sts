@extends('layouts.material')
@section('title', 'My Profile')

@section('content')
<div class="container h-100">
    <table class="table table-borderless d-flex justify-content-center">
      <tbody>
        <tr>
          <td>{!! Avatar::create(Auth::user()->name)->setFontSize(30)->setDimension(150, 150)->toSvg(); !!}</td>
        </tr>
        <tr>
          <td>
            <h3>{{Auth::user()->name}}</h3>
            {{$user->email}}
          </td>
        </tr>
        <tr>
          <td>
            @if(count($user->group) > 0)
            <h4>Group List</h4>
            <ul>
              @foreach($user->group as $group)
              <li>{{$group->group_name}}</li>
              @endforeach
            </ul>
            @endif
          </td>
        </tr>
      </tbody>
    </table>
</div>
@endsection
