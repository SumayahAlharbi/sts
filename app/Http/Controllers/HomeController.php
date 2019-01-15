<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\User;
use Auth;
use App\Group;
use Spatie\Activitylog\Models\Activity;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $userId = Auth::user()->id;
      // $userGroup = Auth::user()->group->first()->id;
      // $ticketUserGroup = Group::find($userGroup)->ticket;

      $tickets = Ticket::paginate(5);
      $ticketsStats = Ticket::all();
      $users = User::withCount('ticket')->take(5)->orderBy('ticket_count', 'desc')->get();
      $activityTickets = Activity::where('subject_type', 'App\Ticket')->orderBy('id', 'desc')->limit(5)->get();

      return view('home', compact('tickets', 'users', 'ticketsStats', 'activityTickets'));
    }

}
