@extends('layouts.material')
@section('title', 'Report')

@section('content')

<div class = 'container'>

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif

<button type="button" class="btn btn-link"></button>


<div class="row">
    <div class="col-12">
<div class="card">

  <div class="card-body">
<h4 class="card-title">Data Generator v0.0.1</h4>

      <form method="post" action="{{url('report/display')}}">
        <div class="row">
          <div class="form-group col-md-4">
              @csrf
              <label for="from_date">from</label>
              <input type="date" class="form-control" name="from_date" />
          </div>
          <div class="form-group col-md-4">
            <label for="to_date">to</label>
            <input type="date" class="form-control" name="to_date" />
          </div>
          <div class="col-md-4">
            <div class="form-group">
            <label for="name">Agent list</label>
              <select name="user_id" id="" data-show-subtext="true" data-live-search="true" class="selectpicker form-control">
                <option selected disabled value> -- Choose an Agent -- </option>
                  @foreach($agentUsers as $agentUser)
                  <option value="{{$agentUser->id}}">{{$agentUser->name}}</option>
                  @endforeach
              </select>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Generate & Download</button>
      </form>





</div>
</div>
</div>
</div>
</div>
@endsection
