<!-- _comment_replies.blade.php -->

@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
    </ul>
  </div><br />
@endif

 @foreach($comments->sortByDesc('updated_at') as $comment)
    <div class="display-comment">


      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-1">
              <img class="rounded mx-auto" src="{{$comment->user->gravatar}}" >
            </div>
            <div class="col-sm-11">
              <strong>{{ $comment->user->name }}</strong>
              <small class="text-muted">{{$comment->created_at->diffForHumans() }}</small>
            </div>
          </div>
        </div>
      </div>

        {{-- <img class="rounded mx-auto" src="{{Auth::user()->gravatar}}" >
        <strong>{{ $comment->user->name }}</strong>
        <small class="text-muted">{{$comment->created_at->diffForHumans() }}</small> --}}

        <p>{{ $comment->body }}</p>
        <a href="" id="reply"></a>
        <form method="post" action="{{ route('reply.add') }}">
            @csrf
            <div class="form-group" required>
                <input type="text" name="comment_body" class="form-control" />
                <input type="hidden" name="ticket_id" value="{{ $tickets->id }}" />
                <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group" required>
                <input type="submit" class="btn btn-secondary" value="Reply" />
            </div>
        </form>
        @include('comments._comment_replies', ['comments' => $comment->replies])
    </div>
@endforeach
