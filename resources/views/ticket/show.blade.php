@extends('layouts.app')

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
   ticket title: {{$tickets->ticket_title}}
  </div>
  <div class="card-body">
    {{$tickets->category->category_name}}
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
</div>
</div></div>
@endsection
