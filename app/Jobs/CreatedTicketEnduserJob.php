<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreatedTicketEnduserMail;

class CreatedTicketEnduserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $ticket;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Ticket $ticket)
    {
        //
        // $this->user = $user;
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->ticket->requested_by_user)->send(new CreatedTicketEnduserMail($this->ticket));

    }
}
