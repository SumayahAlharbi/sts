<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Ticket;
use App\Comment;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketNewCommentReplyMail;

class TicketNewCommentReplyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;
    public $comment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, Comment $comment)
    {
        //
        $this->ticket = $ticket;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $comment_parent_id = Comment::where('id','=',$this->comment->id)->pluck('user_id');
      $comment_parent = User::where('id','=',$comment_parent_id)->pluck('email');
      Mail::to($comment_parent)->send(new TicketNewCommentReplyMail($this->ticket, $this->comment));
    }
}
