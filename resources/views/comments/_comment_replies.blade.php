<!-- _comment_replies.blade.php -->


@foreach($comments as $comment)
<div class="display-comment">
  <div class="d-flex flex-row comment-row">
    <div class="p-2"><span>{!! Avatar::create($comment->user->name)->setFontSize(20)->setDimension(50, 50)->toSvg(); !!}</span></div>
    <div class="comment-text w-100">
      <h5>
        @if( isset( $comment->user->name ))
        {{ $comment->user->name }}
        @endif
      </h5>
      <p class="m-b-5 @if($comment->body == 'This comment has been deleted')alert alert-warning @endif">{!! $comment->body !!}</p>
      {{-- <div class="alert alert-warning alert-rounded"> This is an example top alert. You can edit what u wish.
    </div> --}}
      <div class="comment-footer"> <span class="text-muted pull-right">{{$comment->created_at->diffForHumans() }}</span>
        <span class="action-icons">
          <a href="#" class="reply-init"><i class="fas fa-reply"></i></a>
          <input type="hidden" class="commentParentId" name="comment_id" value="{{ $comment->id  }}" />

          @if(auth()->user()->id==$comment->user_id && $comment->body != 'This comment has been deleted')
          <form style="display:inline;" onsubmit="return confirm('Do you really want to delete?');" action="{{ route('comment.destroyComment', $comment)}}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-link" title="Delete" type="submit"><i class="fas fa-trash-alt"></i></button>
          </form>
          @endif
        </span>
      </div>
    </div>
  </div>





  {{-- <div class="display-comment"> --}}




  {{-- <img class="rounded mx-auto" src="{{Auth::user()->gravatar}}" >
  <strong>{{ $comment->user->name }}</strong>
  <small class="text-muted">{{$comment->created_at->diffForHumans() }}</small> --}}

  {{-- <a href="" id="reply"></a> --}}

  {{-- <div id="reply-input">
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
</div> --}}
@include('comments._comment_replies', ['comments' => $comment->replies])
{{-- </div> --}}
</div>
@endforeach