<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\User;
use Auth;
use App\Comment;
use App\Group;
use Spatie\Activitylog\Models\Activity;


use App\Category;
use App\Location;
use App\Status;
use App\Rating;
use App;
use App\Mail\agent;
use App\Mail\TicketAgentAssigned;
use App\Mail\TicketRating;
use App\Mail\RequestedBy;
use Carbon\Carbon;
use App\Charts\TicketsDonutChart;

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
      $totalTicketSetting = Auth::user()->settings()->get('total_tickets');
      $todayTickets = Ticket::whereDate('due_date', Carbon::now() )->limit(5)->get();
      $todayTicketsTotal = Ticket::whereDate('due_date', Carbon::now() )->count();
      $lateTickets = Ticket::whereDate('due_date', '<', Carbon::now() )->where('status_id','!=', '1')->limit(5)->get();
      $lateTicketsTotal = Ticket::whereDate('due_date', '<', Carbon::now() )->where('status_id','!=', '1')->count();
      // $tickets = Ticket::paginate(5);
      // $ticketsStats = Ticket::all();
      // $users = User::withCount('ticket')->take(5)->orderBy('ticket_count', 'desc')->get();
      $activityTickets = Activity::where('subject_type', 'App\Ticket')->orderBy('id', 'desc')->limit(5)->get();
      $locations = Location::all()->pluck('location_name','id');
      $categories = Category::all()->pluck('category_name','id');
      $statuses = Status::all();
      $created_by = Auth::user();
      //  $now = Carbon::now()->addHours(3);
        if (Auth::user()->hasRole('admin|enduser')) {
          $groups = Group::all();
        }else {
          $groups = Auth::user()->group;
        }
       $user = Auth::user();
       $group=Group::all();
     $userGroups = Group::with('user')->get()->unique();

     //Chart
     $ticketsPending = Ticket::Pending()->count();
     $ticketsInProgress = Ticket::InProgress()->count();
     $ticketsScheduled = Ticket::Scheduled()->count();
     $ticketsCompleted = Ticket::Completed()->count();
     $ticketsUnassigned = Ticket::Unassigned()->count();
    //  $ticketsStatus = Ticket::where('status_id', '1')->count();

     $chart = new TicketsDonutChart;
     $chart->labels(['Pending', 'InProgress', 'Scheduled', 'Unassigned']);
     $options = array(
      'backgroundColor' => [
        'rgb(255, 159, 64)',
        'rgb(116, 90, 242)',
        'rgb(0, 0, 0)',
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)',
    ],
  );
     $chart->dataset('My dataset', 'doughnut', [$ticketsPending, $ticketsInProgress, $ticketsScheduled, $ticketsUnassigned])->options($options,true);
    // $chart->dataset('My dataset', 'doughnut', [1, 2, 3, 4])->options($options,true);

     

      return view('home', compact('ticketsPending', 'ticketsInProgress', 'ticketsScheduled', 'ticketsCompleted', 'ticketsUnassigned', 'chart','todayTickets', 'todayTicketsTotal', 'lateTickets', 'lateTicketsTotal', 'categories','locations','statuses','created_by', 'groups', 'activityTickets','userGroups'));
    }

    // public function TicketsChartsApi()
    // {
    //     $Pending = Ticket::where('status_id','=','4')->count();
    //     $InProgress = Ticket::where('status_id','=','5')->count();
    //     $Scheduled = Ticket::where('status_id','=','2')->count();
    //     // $Completed = Ticket::where('status_id','=','1')->count();
    //     $Unassigned = Ticket::where('status_id','=','3')->count();
    //     $StatsArray = array('Pending'=>$Pending,
    //                         'InProgress'=>$InProgress,
    //                         'Scheduled'=>$Scheduled,
    //                         // 'Completed'=>$Completed,
    //                         'Unassigned'=>$Unassigned);
    //     return response()->json($StatsArray);
    // }

}
