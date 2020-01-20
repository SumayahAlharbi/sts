<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Ticket;
use App\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketNewCommentAgentMail;

class TicketNewCommentAgentJob implements ShouldQueue
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
        $ticketAgents = $this->ticket->user;
        foreach ($ticketAgents as $ticketAgent) {
          if ($ticketAgent != $this->comment->user)
          {
            Mail::to($ticketAgent)->send(new TicketNewCommentAgentMail($this->ticket, $this->comment));
          }
      }
    }
}
