<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Comment;
use App\User;
use App\Ticket;
use App\Mail\TicketNewCommentRequestedMail;
use Carbon\Carbon;
use App\Jobs\TicketNewCommentRequestedJob;
use App\Jobs\TicketNewCommentAgentJob;
use App\Jobs\TicketNewCommentReplyJob;

class CommentController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'comment_body' => 'required',
    ]);
    $comment = new Comment;
    $comment->body = $request->get('comment_body');
    $comment->user()->associate($request->user());
    $ticket = Ticket::find($request->get('ticket_id'));
    $ticket->comments()->save($comment);
    $ticketAgents = $ticket->user;
    $requested_by = $ticket->requested_by_user;
    $comment_author = $request->user();
    // New email to Enduser if anyone except himself commented on his ticket
    if ($requested_by)
    if ($requested_by != $comment_author)
    {
      if (App::environment('production')) {
        //\Mail::to($requested_by)->send(new TicketNewComment($ticket, $comment));
        //TicketNewCommentRequestedJob::dispatch($ticket, $comment);
      }
    }

    if ($ticketAgents->isEmpty()) {
      return back();
    } else {
      // New email to ticket Agent(s) if anyone except himself commented on his ticket
      if (App::environment('production')) {
        //TicketNewCommentAgentJob::dispatch($ticket, $comment);
      }
    }
    return back();
  }

  public function replyStore(Request $request)
  {
    $request->validate([
      'comment_body' => 'required',
    ]);
    $comment = new Comment();
    $comment->body = $request->get('comment_body');
    $comment->user()->associate($request->user());
    $comment->parent_id = $request->get('comment_id');
    $ticket = Ticket::find($request->get('ticket_id'));
    $ticket->comments()->save($comment);

    //Send Email to Comment Parent if anyone replys to his comment except himself
    $comment_author = $request->user()->id;
    $comment_parent_id = Comment::where('id','=',$request->get('comment_id'))->value('user_id');
    if ($comment_author != $comment_parent_id)
    {
      if (App::environment('production')) {
        //TicketNewCommentReplyJob::dispatch($ticket, $comment);
      }
    }

    return back();
  }
  public function destroyComment($id)
  {
    $comment =  Comment::findOrfail($id);
    $currentTime = Carbon::now();
    $updatedAt = $comment->updated_at;
    $diffInMinutes = $currentTime->diffInMinutes($updatedAt, true);
    if ($diffInMinutes < 5) {
      $comment->deleted_at = $currentTime;
      $comment->body = 'This comment has been deleted';
      $comment->save();
      return back()->with('success', 'The comment has been deleted successfully');
    } else {
      return back()->with('errors', 'This comment cannot be deleted');
    }
  }
}
