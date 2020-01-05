<?php

namespace App\Mail;

use App\Ticket;
use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketNewCommentAgentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $ticket;
    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct(Ticket $ticket, Comment $comment)
     {
         $this->ticket = $ticket;
         $this->comment = $comment;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[New] Comment in Your Ticket')
        ->view('emails.ticket.ticketnewcommentrequested');
    }
}
