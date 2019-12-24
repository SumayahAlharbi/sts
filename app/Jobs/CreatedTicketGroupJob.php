<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Ticket;
use App\User;
use App\Group;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreatedTicketGroupMail;

class CreatedTicketGroupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $group;
    public $ticket;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Group $group, Ticket $ticket)
    {
        //
        $this->group = $group;
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
        Mail::to($this->group)->send(new CreatedTicketGroupMail($this->ticket));
    }
}
