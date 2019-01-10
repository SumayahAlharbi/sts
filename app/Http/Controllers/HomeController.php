<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\User;
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
      $tickets = Ticket::paginate(5);
      $ticketsStats = Ticket::orderByRaw('created_at DESC')->get();
      $users = User::all();
      $activityTickets = Activity::where('subject_type', 'App\Ticket')->paginate(15);
      return view('home', compact('tickets', 'users', 'ticketsStats', 'activityTickets'));
    }

}
