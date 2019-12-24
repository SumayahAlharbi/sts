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
            <label for="exampleFormControlSelect1">Allow KSAU-HS endusers to request tickets from this group</label>
            <div class="switch">
                <label>
                  OFF
                  {{-- <input type="checkbox" checked=""> --}}
                  <input data-id="{{$group->id}}" data-setting="allow_enduser_ticket" class="toggle-class change-group-setting" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="true" data-off="false" {{ $group->settings()->get('allow_enduser_ticket')   == 1 ? 'checked' : '' }}>
                  <span class="lever switch-col-light-green"></span>
                  ON
                </label>
        </div>
      </div>

      <div class="form-group">
          <label for="exampleFormControlSelect1">Send assign email to agent</label>
          <div class="switch">
              <label>
                OFF
                {{-- <input type="checkbox" checked=""> --}}
                <input data-id="{{$group->id}}" data-setting="email_assigned_agent"  class="toggle-class change-group-setting" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="true" data-off="false" {{ $group->settings()->get('email_assigned_agent')  == 1 ? 'checked' : '' }}>
                <span class="lever switch-col-light-green"></span>
                ON
              </label>
      </div>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Send new ticket email to departmental email</label>
        <div class="switch">
            <label>
              OFF
              {{-- <input type="checkbox" checked=""> --}}
              <input data-id="{{$group->id}}" data-setting="email_ticket_departmental" class="toggle-class change-group-setting" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="true" data-off="false" {{ $group->settings()->get('email_ticket_departmental')  == 1 ? 'checked' : '' }}>
              <span class="lever switch-col-light-green"></span>
              ON
            </label>
    </div>
  </div>

  <div class="form-group">
      <label for="exampleFormControlSelect1">Send ticket confirmation email to enduser</label>
      <div class="switch">
          <label>
            OFF
            {{-- <input type="checkbox" checked=""> --}}
            <input data-id="{{$group->id}}" data-setting="email_ticket_confirmation" class="toggle-class change-group-setting" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="true" data-off="false" {{ $group->settings()->get('email_ticket_confirmation')  == true ? 'checked' : '' }}>
            <span class="lever switch-col-light-green"></span>
            ON
          </label>
  </div>
</div>

<div class="form-group">
    <label for="exampleFormControlSelect1">Send ticket rating email to enduser</label>
    <div class="switch">
        <label>
          OFF
          {{-- <input type="checkbox" checked=""> --}}
          <input data-id="{{$group->id}}" data-setting="email_ticket_rating" class="toggle-class change-group-setting" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="true" data-off="false" {{ $group->settings()->get('email_ticket_rating')  == true ? 'checked' : '' }}>
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
      $('.change-group-setting').change(function() {
          var setting_value = $(this).prop('checked') == true ? 1 : 0;
          var group_id = $(this).data('id');
          var setting_name = $(this).data('setting'); 
           
          $.ajax({
              type: "GET",
              dataType: "json",
              url: '{{ route('group.change.setting') }}',
              data: {'setting_value': setting_value, 
              'group_id': group_id, 
              'setting_name': setting_name
            },
            success: function (data) {
                // console.log(data.message);
            }
          });
      })
    })


  </script>
@endsection
