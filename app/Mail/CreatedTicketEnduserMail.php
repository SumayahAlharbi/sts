<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Ticket;

class CreatedTicketEnduserMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->subject('[Confirmation] Your ticket has been recivied')
      ->view('emails.ticket.createdticketenduser');
    }
}
