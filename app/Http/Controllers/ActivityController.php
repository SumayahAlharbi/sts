<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Ticket;
use App\User;

class ActivityController extends Controller
{
  public function index()
  {
    $activityTickets = Activity::where('subject_type', 'App\Ticket')->get();
    $activityUsers = Activity::where('subject_type', 'App\User')->get();

    return view('activity.index', compact('activityTickets','ticket','user','CauserInfo','TicketInfo','activityUsers'));
  }

}
