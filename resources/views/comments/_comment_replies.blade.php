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

 @foreach($comments as $comment)
<div class="d-flex flex-row comment-row">
    <div class="p-2"><span>{!! Avatar::create($user->name)->setFontSize(20)->setDimension(50, 50)->toSvg(); !!}</span></div>
    <div class="comment-text w-100">
        <h5>{{ $comment->user->name }}</h5>
        <p class="m-b-5">{{ $comment->body }}</p>
        <div class="comment-footer"> <span class="text-muted pull-right">{{$comment->created_at->diffForHumans() }}</span>
          <span class="action-icons">
                    {{-- <a href="javascript:void(0)"><i class="fas fa-reply"></i></a> --}}
                    {{-- <a href="javascript:void(0)"><i class="ti-check"></i></a>
                    <a href="javascript:void(0)"><i class="ti-heart"></i></a> --}}
          </span>
              </div>
    </div>
</div>


    {{-- <div class="display-comment"> --}}




        {{-- <img class="rounded mx-auto" src="{{Auth::user()->gravatar}}" >
        <strong>{{ $comment->user->name }}</strong>
        <small class="text-muted">{{$comment->created_at->diffForHumans() }}</small> --}}

        {{-- <a href="" id="reply"></a>
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
        </form> --}}
        {{-- @include('comments._comment_replies', ['comments' => $comment->replies])
    </div> --}}
@endforeach
