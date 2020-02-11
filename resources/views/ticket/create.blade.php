@extends('layouts.material')
@section('title', 'Create Ticket')

@section('content')
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

<style>
  .uper {
    margin-top: 40px;
  }
</style>
<script>
  $(function () {
      $('.myselect').selectpicker();
  });        //update group after region select in defult model
          $(document).on('change','.region', function(e){
          var region_id = e.target.value;
          $.getJSON('/getGroups/' + region_id, function(data) {
                $("#groupDiv").show();
                $('#group_id').empty();
                // var groups = [];
                // @foreach($userGroups as $userGroupsId) 
                //   $userGroupsIdArray[] =  $userGroupsId->region_id;
                // @endforeach
                // var hiddenField = $( ".filter-option-inner-inner" ).text();
                // document.getElementById("requested_by_name").value = hiddenField;
                var userGroupsRegion = 
                [
                  @foreach($userGroups as $userGroupsId) 
                      "{{ $userGroupsIdArray[] =  $userGroupsId->region_id }}",
                    @endforeach
                ];

    //             var n = userGroupsRegion.includes(region_id);
    //             if(n.indexOf("Mango") !== -1){
    //     alert("Value exists!")
    // } else{
    //     alert("Value does not exists!")
    // }
    // var groupRegionArr = ["Apple", "Banana", "Mango", "Orange", "Papaya"];
    // var groupRegionArr = userGroupsRegion.includes(region_id);
    
    // Check if a value exists in the fruits array
    if(userGroupsRegion.indexOf(region_id) > -1){
      // alert("Value exists!")

    var groups = [];
                $('#group_id').append('<optgroup label="Your Department">');
                  @foreach($userGroups as $userGroup )
                    // groups.push({ id: '{{ $userGroup->id }}', text: '{{ $userGroup->group_name }}' });

                    var optgroup = "<option value='{{$userGroup->id}}'>{{$userGroup->group_name}}</option>"
                    $('#group_id').append(optgroup);
                  @endforeach
                  // for (var i = 0; i < groups.length; i++) {
                  //   var optgroup = "<option value='" + groups[i].id + "'>" + groups[i].text + "</option>"
                  // }
                
                
                $('#group_id').append("</optgroup>");

              } else{
      // alert("Value does not exists!")
    }
                $('#group_id').append('<optgroup label="KSAU-HS Departments">');
                $.each(data,function(index, subcatObj){
                  $('#group_id').append("<option value="+subcatObj.id+">"+subcatObj.group_name+"</option>");
                });
                $('#group_id').append("</optgroup>");
            });
  
          });
          //update location after group select in defult model
          $(document).on('change','.group', function(e){
          var group_id = e.target.value;
          $.getJSON('/getLocations/' + group_id, function(data) {
                $("#locationDiv").show();
                $('#location_id').empty();
                $('#location_id').append("<option value=''>Select your location</option>");
                $.each(data,function(index, subcatObj){
                  $('#location_id').append("<option value="+subcatObj.id+">"+subcatObj.location_name+"</option>");
  
                });
            });
            $.getJSON('/getCategory/' + group_id, function(data) {
                  $("#categoryDiv").show();
                      $('#category_id').empty();
                      $('#category_id').append("<option value=''>Select a category</option>");
                      $.each(data,function(index, subcatObj){
                        $('#category_id').append("<option value="+subcatObj.id+">"+subcatObj.category_name+"</option>");
  
                  });
              });
          });
          //update group after region select in Enduser model
          $(document).on('change','.regionEnduser', function(e){
          var region_id = e.target.value;
          $.getJSON('/getGroups/' + region_id, function(data) {
                $("#groupDivEnduser").show();
                $('#groupEnduser').empty();
                $('#groupEnduser').append("<option value=''>Select department</option>");
                $.each(data,function(index, subcatObj){
                  $('#groupEnduser').append("<option value="+subcatObj.id+">"+subcatObj.group_name+"</option>");
  
                });
            });
          });
          //update location after group select in Enduser model
          $(document).on('change','.groupEnduser', function(e){
            var group_id = e.target.value;
            $.getJSON('/getLocations/' + group_id, function(data) {
                  $("#locationDivEnduser").show();
                  $('#locationEnduser').empty();
                  $('#locationEnduser').append("<option value=''>Select your location</option>");
                  $.each(data,function(index, subcatObj){
                    $('#locationEnduser').append("<option value="+subcatObj.id+">"+subcatObj.location_name+"</option>");
  
                  });
              });
            $.getJSON('/getCategory/' + group_id, function(data) {
                  $("#categoryDivEnduser").show();
                      $('#categoryEnduser').empty();
                      $('#categoryEnduser').append("<option value=''>Select a category</option>");
                      $.each(data,function(index, subcatObj){
                        $('#categoryEnduser').append("<option value="+subcatObj.id+">"+subcatObj.category_name+"</option>");
  
                  });
              });
          });
  </script>

<div class = 'row'>
<div class="col-12">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">
    + New Ticket
    </h4>

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
            <form method="post" action="{{ route('ticket.store') }}">

                <div class="form-group">
                    @csrf
                    <label for="name">Ticket Title</label>
                    <input type="text" class="form-control" name="ticket_title" value="{{ old('ticket_title') }}" autofocus required/>
                </div>

                <div class="form-group">
                  <label class="control-label">Priority</label>
                  <select class="form-control custom-select" name="priority" data-placeholder="Choose a Priority Level">
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Critical">Critical</option>
                  </select>

              </div>

              <div class="form-group">
                <label for="name">Due Date (Optional)</label>
                <input type="text" id="datetimepicker" placeholder="YYYY-MM-DD hh:mm:ss" class="form-control" name="due_date" value="{{ old('due_date') }}" minlength="19" maxlength="19" readonly/>
                {{-- <small class="form-control-feedback"> Date/Time Format: {{ $now }} </small> --}}
              </div>

                <div class="form-group">
                    <label for="ticket_content">Ticket Content</label>
                    <textarea name="ticket_content" class="form-control" id="contentEditor" rows="3" value="{{ old('ticket_content') }}" required></textarea>
                    <script>
                      CKEDITOR.replace( 'contentEditor' );
                    </script>
                </div>

                <div class="form-group">
                  <label for="exampleFormControlSelect1">Region</label>
                  <select required class="form-control region" name="region" id="region">
                    <option value="">None</option>
                    @foreach ($regions as $key => $value)
                      <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                  </select>
                </div>
                
                <div class="form-group" style="display:none;" id="groupDiv">
                <label for="exampleFormControlSelect1">Request from</label>
                {{-- <select required class="form-control group" name="group_id" id="group_id" placeholder="please select the department">
                  @foreach ($groups as $group)
                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                  @endforeach
                </select> --}}
                <select class="form-control group" name="group_id" id="group_id" required>
                  {{-- @if(Auth::user()->group) --}}
                  {{-- @unless(Auth::user()->hasRole('agent')) --}}
                  {{-- <option disabled="disabled" selected="selected">Select Departments/Groups</option> --}}
                  <optgroup id="his-group" label="Your Departments/Groups">
                    @foreach ($userGroups as $userGroup)
                    <option value="{{$userGroup->id}}">{{$userGroup->group_name}}</option>
                    @endforeach
                  </optgroup>
                  {{-- @endunless --}}
                  {{-- @endif --}}
                  {{-- <optgroup label="KSAU-HS Departments">
                    @foreach ($groups as $group)
                      <option value="{{$group->id}}">{{$group->group_name}}</option>
                    @endforeach
                </optgroup> --}}
                </select>
                {{-- <input type="text" class="form-control" id="requested_by_name" name="requested_by_name" value="" hidden/> --}}
              </div>

                <div class="form-group" style="display:none;" id="locationDiv">
                  <label for="exampleFormControlSelect1">Location</label>
                  <select required class="form-control" name="location_id" id="location_id">
                    <option value="">None</option>
                    @foreach ($locations as $key => $value)
                      <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group" style="display:none;" id="categoryDiv">
                  <label for="exampleFormControlSelect1">Category</label>
                  <select required class="form-control" name="category_id" id="category_id">
                    <option value="">None</option>
                    @foreach ($categories as $key => $value)
                      <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                  </select>
                </div>

              <div class="form-group">
                <label for="name">Room Number</label>
                <input type="text" class="form-control" name="room_number" value="{{ old('room_number') }}"/>
              </div>

        @if (Auth::user()->hasRole('admin') or Auth::user()->hasPermissionTo('view group tickets'))
        <div class="form-group" required>
          <label for="exampleFormControlSelect1">Requested by</label>
        {{-- <select class="selectpicker form-control" name="requested_by" data-show-subtext="true" data-live-search="true">
          <option selected value> -- Who requested this ticket? -- </option>
          @foreach ($users as $key => $value)
            @if ($key == $created_by->id)
            <option value="{{$key}}">(Current) {{$value}}</option>
            @else
            <option value="{{$key}}">{{$value}}</option>
            @endif
          @endforeach
        </select> --}}

        <select id="ajax-select" class="selectpicker" name="requested_by" data-live-search="true"></select>
        <input type="text" class="form-control" id="requested_by_name" name="requested_by_name" value="" hidden/>
      </div>
      @endif

      @if (Auth::user()->hasPermissionTo('rate ticket') or Auth::user()->hasRole('agent'))
      <div class="form-group" required>
          <label for="exampleFormControlSelect1">Requested by</label>
        <select class="selectpicker form-control" data-show-subtext="true" data-live-search="true" disabled>
          @foreach ($users as $key => $value)
            @if ($key == $created_by->id)
            <option value="{{$key}}">(Current) {{$value}}</option>
            <input type="text" class="form-control" name="requested_by" value="{{$created_by->email}}" hidden/>
            
            @endif
          @endforeach
        </select>
      </div>
      @endif

      {{-- <script>
          $(function() {
            $('.toggle-class').change(function() {
                // var visibility_id = $(this).prop('checked') == true ? 1 : 0;
                var userKeyword = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('graph.users.list') }}',
                    data: {'userKeyword': userKeyword},
                  success: function (data) {
                      // console.log(data.message);
                  }
                });
            })
          })
        </script> --}}
        <script>
        $('.selectpicker-group').selectpicker();
        $('.selectpicker').selectpicker().ajaxSelectPicker({
ajax: {

// data source
url: '{{ route('graph.users.list') }}',

// ajax type
type: 'GET',

// data type
dataType: 'json',

// Use  as a placeholder and Ajax Bootstrap Select will
// automatically replace it with the value of the search query.
data: {
q: '{@{{q}}}'
}
},

// function to preprocess JSON data
preprocessData: function (data) {
var i, l = data.length, array = [];
// var hiddenField = $( "optgroup option:selected" ).text();
if (l) {
for (i = 0; i < l; i++) {
array.push($.extend(true, data[i], {
text : data[i].displayName,
value: data[i].mail,
data : {
subtext: data[i].mail
}
}));
// $( "optgroup option:selected" ).text();
}
// console.log(hiddenField);
// console.log(data);
}
// You must always return a valid array when processing data. The
// data argument passed is a clone and cannot be modified directly.
return array;
// $( "optgroup option:selected" ).text();
}

});
// var hiddenField = $( "optgroup option:selected" ).text();
// console.log(hiddenField);
        $(function() {
            $('.selectpicker').change(function() {
                var hiddenField = $( ".filter-option-inner-inner" ).text();
                document.getElementById("requested_by_name").value = hiddenField;
                console.log(hiddenField);
            })
          })
        </script>




                <div class="form-group">
                    <input type="text" class="form-control" name="created_by" value="{{$created_by->id}}" hidden />
                </div>
                <button type="submit" class="btn btn-block btn-lg btn-primary col-md-12">Create</button>
            </form>

  </div>
</div></div>
@endsection
