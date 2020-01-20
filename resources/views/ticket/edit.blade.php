@extends('layouts.material')
@section('title', 'Edit: ' . $ticket->ticket_title)

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
    Edit Ticket
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
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script>
            
          $(document).on('change','.group', function(e){

              var group_id = e.target.value;

              $.getJSON('/getLocations/' + group_id, function(data) {
                    $('#location_id').empty();
                    $('#location_id').append("<option value=''>Select your location</option>");
                    $.each(data,function(index, subcatObj){
                      $('#location_id').append("<option value="+subcatObj.id+">"+subcatObj.location_name+"</option>");

                    });
              });
              $.getJSON('/getCategory/' + group_id, function(data) {
                        $('#category_id').empty();
                        $('#category_id').append("<option value=''>Select a category</option>");
                        $.each(data,function(index, subcatObj){
                          $('#category_id').append("<option value="+subcatObj.id+">"+subcatObj.category_name+"</option>");

                        });
              });
          });
    </script>
      <form method="post" action="{{ route('ticket.update', $ticket->id) }}">
        @method('PATCH')
        @csrf
        <div class="row p-t-20">
        <div class="form-group col-md-12">
          <label for="name">Ticket Title:</label>
          <input type="text" class="form-control" name="ticket_title" value="{{ $ticket->ticket_title }}"/>
        </div>
      </div>
      <div class="row p-t-20">
        <div class="form-group col-md-6">
          <label class="control-label">Priority</label>
          <select class="form-control custom-select" name="priority" data-placeholder="Choose a Priority Level" tabindex="1">
                <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
                <option value="Critical" {{ $ticket->priority == 'Critical' ? 'selected' : '' }}>Critical</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="name">Due Date</label>
          <input type="text" placeholder="YYYY-MM-DD hh:mm:ss" class="form-control" name="due_date" value="{{ $ticket->due_date }}" id="datetimepicker" readonly />
          {{-- <small class="form-control-feedback"> Date/Time Format: {{ $now }} </small> --}}
        </div>
      </div>
        <div class="form-group">
          <label for="price">Ticket content:</label>
          {{-- <input type="text" class="form-control" name="ticket_content" value="{{ $ticket->ticket_content }}" /> --}}
          <textarea name="ticket_content" class="form-control" id="editor" rows="3">{{ $ticket->ticket_content }}</textarea>
          <script>
                CKEDITOR.replace( 'editor' );
          </script>
        </div>
        <div class="row">
        <div class="form-group col-md-4">
          <label for="exampleFormControlSelect1">Status</label>
          <select class="form-control" name="status_id" id="exampleFormControlSelect1">
            @foreach ($statuses as $key => $value)
              @if ($key == $ticket->status_id)
           <option selected value="{{$key}}">{{$value}}</option>
           @else
           <option value="{{$key}}">{{$value}}</option>
           @endif
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="category_id">Category</label>
          <select required class="form-control category" name="category_id" id="category_id">
            @foreach ($categories as $key => $value)
              @if ($key == $ticket->category_id)
           <option selected value="{{$key}}">{{$value}}</option>
           @else
           <option value="{{$key}}">{{$value}}</option>
           @endif
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="group_id">Group</label>
            <select required class="form-control group" name="group_id" id="group_id">
              @foreach ($groups as $group)
                @if ($group->id == $ticket->group_id)
             <option selected value="{{$group->id}}">{{$group->group_name}}</option>
             @else
             <option value="{{$group->id}}">{{$group->group_name}}</option>
             @endif
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-4">
          <label for="location_id">Location</label>
          <select required class="form-control location" name="location_id" id="location_id">
            @foreach ($locations as $key => $value)
              @if ($key == $ticket->location_id)
           <option selected value="{{$key}}">{{$value}}</option>
           @else
           <option value="{{$key}}">{{$value}}</option>
           @endif
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="name">Room Number</label>
          <input type="text" class="form-control" name="room_number" value="{{ $ticket->room_number }}"/>
        </div>
        <div class="form-group col-md-4">
          <label for="exampleFormControlSelect1">Requested by
              @foreach($users as $user)
              @if ($user->id == $ticket->requested_by)
             {{$user->name}}
           @else
           {{-- <option value="{{$user->id}}">{{$user->name}}</option> --}}
           @endif
            @endforeach
          </label>
          {{-- <select class="selectpicker form-control" name="requested_by"data-show-subtext="true" data-live-search="true"  id="exampleFormControlSelect1"> --}}
          <select id="ajax-select" class="selectpicker form-control" name="requested_by" data-live-search="true"></select>
          <input type="text" class="form-control" id="requested_by_name" name="requested_by_name" value="" hidden/>
            {{-- @empty($user->id) --}}
          {{-- <option selected value> -- Who requested this ticket? -- </option> --}}
          {{-- @endempty --}}
            {{-- @foreach($users as $user)
              @if ($user->id == $ticket->requested_by)
             <option selected value="{{$user->id}}">{{$user->name}}</option>
           @else --}}
           {{-- <option value="{{$user->id}}">{{$user->name}}</option> --}}
           {{-- @endif
            @endforeach --}}
          </select>
        </div>
      </div>

      <script>
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
locale: {
            emptyTitle: 'Click to change'
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
                  var hiddenField = $( "optgroup option:selected" ).text();
                  document.getElementById("requested_by_name").value = hiddenField;
                  console.log(hiddenField);
              })
            })
          </script>

        <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>


  </div>
</div>
</div>

@endsection
