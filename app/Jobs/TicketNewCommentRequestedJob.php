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
use App\Mail\TicketNewCommentRequestedMail;

class TicketNewCommentRequestedJob implements ShouldQueue
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
        //
        Mail::to($this->ticket->requested_by_user)->send(new TicketNewCommentRequestedMail($this->ticket, $this->comment));
    }
}
