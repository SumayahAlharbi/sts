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
      $users = User::paginate(6);
      $activityTickets = Activity::where('subject_type', 'App\Ticket')->paginate(15);


        //   if (Auth::user()->hasRole('admin')) {
        //   $tickets = Ticket::paginate(5);
        //   $ticketsStats = Ticket::all();
        //   $users = User::paginate(6);
        //   $activityTickets = Activity::where('subject_type', 'App\Ticket')->paginate(15);
        //
        // } elseif (Auth::user()->hasPermissionTo('view group tickets')) {
        //
        //   $tickets = Ticket::where('group_id', $userGroup)->orderByRaw('created_at DESC')->limit(6)->get();
        //   $ticketsStats = Ticket::where('group_id', $userGroup)->get();
        //   $users = User::paginate(6);
        //   $activityTickets = Activity::where('subject_type', 'App\Ticket')->paginate(15);
        // } else {
        //   $tickets = Ticket::whereHas('user', function ($q) use ($userId) {
        //   $q->where('user_id', $userId);})->limit(6)->get();
        //   $ticketsStats = Ticket::whereHas('user', function ($q) use ($userId) {
        //   $q->where('user_id', $userId);})->get();
        //   $users = Auth::user()->paginate(6);
        //   $activityTickets = Activity::where('subject_type', 'App\Ticket')->paginate(15);
        // }



      return view('home', compact('tickets', 'users', 'ticketsStats', 'activityTickets'));
    }

}
