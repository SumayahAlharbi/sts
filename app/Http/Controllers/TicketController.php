<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Category;
use App\Location;
use App\Status;
use App\Group;
use App\User;
use App\Rating;
use App\Region;
use App\Release;
use Auth;
use App;
use App\Mail\agent;
use App\Mail\TicketAgentAssigned;
use App\Mail\TicketRating;
use App\Mail\RequestedBy;
use App\Mail\TicketCreated;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use App\Notifications\AssignedTicket;
use Illuminate\Support\Facades\Hash;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

use Illuminate\Http\Request;

class TicketController extends Controller
{
//   private $tickets;
//   public function __construct(Ticket $tickets)
// {
//   // $this->middleware('role:admin')->only('index','show');
//   // $this->middleware('role:admin', ['except' => ['index', 'show', 'ChangeTicketStatus']]);
//   $this->$tickets = $tickets;
//
// }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        $releases = Release::orderByRaw('created_at DESC')->first();
        //$diffHours = diffInHours($releases['created_at'])->now();
        $tickets = Ticket::orderByRaw('created_at DESC')->simplePaginate(10);
        $regions = Region::all()->pluck('name','id');
        $categories = Category::all()->pluck('category_name','id');
        $locations = Location::all()->pluck('location_name','id');
        $users = User::all()->pluck('name','id');
        $created_by = Auth::user();
      //  $now = Carbon::now()->addHours(3);
        if (Auth::user()->hasRole('admin')) {
          $groups = Group::all();
        }elseif(Auth::user()->hasRole('enduser')){
          $groups = Group::where('visibility_id','=','1')->get();
        }else {
          $groups = Auth::user()->group;
        }
        //return $groups;
        ActivityLogger::activity("Ticket index");
        return view('ticket.index', compact('tickets', 'statuses', 'categories','locations','users','created_by', 'groups','regions','releases'));
    }

        /**
     * Display a listing of the deleted tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function deletedTickets()
    {
          $statuses = Status::all();
          $tickets = Ticket::onlyTrashed()->orderByRaw('created_at DESC')->simplePaginate(10);
          $categories = Category::all()->pluck('category_name','id');
          $locations = Location::all()->pluck('location_name','id');
          $users = User::all()->pluck('name','id');
          $created_by = Auth::user();
        //  $now = Carbon::now()->addHours(3);
          if (Auth::user()->hasRole('admin')) {
            $groups = Group::all();
          }elseif(Auth::user()->hasRole('enduser')){
            $groups = Group::where('visibility_id','=','1')->get();
          }else {
            $groups = Auth::user()->group;
          }
        return view('ticket.trash', compact('tickets', 'statuses', 'categories','locations','users','created_by', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('category_name','id');
        $locations = Location::all()->pluck('location_name','id');
        $regions = Region::all()->pluck('name','id');
        $users = User::all()->pluck('name','id');
        $created_by = Auth::user();
        if (Auth::user()->hasRole('admin')) {
          $groups = Group::all();
        }elseif(Auth::user()->hasRole('enduser')){
          $groups = Group::where('visibility_id','=','1')->get();
        }else {
          $groups = Auth::user()->group;
        }
        return view('ticket.create', compact('categories','locations','users','created_by', 'groups','regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'ticket_title'=>'required',
          'ticket_content'=> 'required',
          'group_id'=> 'required',
          'location_id'=> 'required',
          'category_id'=> 'required',
          // 'due_date'=> 'date_format:Y-m-d H:i:s|nullable',
        ]);

        $ticket = new Ticket;

        $ticket->ticket_title = $request->ticket_title;
        $ticket->ticket_content = $request->ticket_content;
        $ticket->category_id = $request->category_id;
        $ticket->location_id = $request->location_id;
        $ticket->group_id = $request->group_id;
        $ticket->status_id = '3';
        $ticket->priority = $request->priority;
        $ticket->due_date = $request->due_date;
        $ticket->room_number = $request->room_number;
        $ticket->created_by = $request->created_by;
        $graphUserEmail = $request->requested_by;

        if ($request->requested_by){
        $userFinder = User::where('email', $graphUserEmail)->first();
        if(!$userFinder){
          $userFinder = new User;
          $userFinder->name = $request->requested_by_name;
          $userFinder->email = $graphUserEmail;
          $userFinder->password= Hash::make('the-password-of-choice');
          // $user->name= $username;
          // $user->email= $username."@ksau-hs.edu.sa";
          // $user->password= Hash::make('the-password-of-choice');
          $userFinder->save();
          $userFinder->assignRole('enduser');
        }

        $ticket->requested_by = $userFinder->id;
      }
        $ticket->save();

        $user = $ticket->requested_by_user;
        if ($user){
          if (App::environment('production')) {
            \Mail::to($user)->send(new RequestedBy($user,$ticket));
          }
        }

        // send the ticket group email about new unassigned ticket
        $this->sendTicketCreatedEmail($ticket->id);

        return redirect('ticket/'. $ticket->id)->with('success', 'Ticket has been created');
    }

    // Send Email to the ticket Group if the ticket is unassigned for 5 min
    public function sendTicketCreatedEmail($ticket_id)
    {
      $ticket = Ticket::findorfail($ticket_id);
      $group_email = $ticket->group->email;
      $created_by = $ticket->created_by;
      $requested_by = $ticket->requested_by;

      // Prevent sending group notification email if (created by != requested by)
      // Prevent sending group notification email if the group email is empty
      if($group_email && ($requested_by != $created_by)){
        if (App::environment('production')) {
            // The environment is production
            \Mail::to($group_email)->send(new TicketCreated($ticket));
        }
      }

      return back();
    }

    public function Enduserstore(Request $request)
    {
        $request->validate([
          'ticket_title'=>'required',
          'ticket_content'=> 'required',
          'groupEnduser'=> 'required',
          'locationEnduser'=> 'required',
          'categoryEnduser'=> 'required',
          // 'due_date'=> 'date_format:Y-m-d H:i:s|nullable',
        ]);
        $ticket = new Ticket;

        $ticket->ticket_title = $request->ticket_title;
        $ticket->ticket_content = $request->ticket_content;
        $ticket->category_id = $request->categoryEnduser;
        $ticket->location_id = $request->locationEnduser;
        $ticket->group_id = $request->groupEnduser;
        $ticket->status_id = '3';
        $ticket->priority = $request->priority;
        // $ticket->due_date = $request->due_date;
        $ticket->room_number = $request->room_number;
        $ticket->created_by = $request->created_by;
        $ticket->requested_by = $request->requested_by;

        $ticket->save();
        $user = $ticket->requested_by_user;

        if (App::environment('production')) {
          \Mail::to($user)->send(new RequestedBy($user,$ticket));
        }

        // send the ticket group email about new unassigned ticket
        $this->sendTicketCreatedEmail($ticket->id);

        return redirect('ticket/'. $ticket->id)->with('success', 'Ticket has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $tickets =  Ticket::findOrfail($id);
        $user = Auth::user();

        $groupId = $tickets->group_id;
            $users = User::whereHas('group', function ($q) use ($groupId) {
                $q->where('group_id', $groupId);
            })->get();

        $TicketAgents = $tickets->user;
        $statuses = Status::all();
        $locations = Location::withoutGlobalScopes()->get();

        $next = Ticket::where('id', '>', $tickets->id)->orderBy('id')->first();
        $previous = Ticket::where('id', '<', $tickets->id)->orderBy('id','desc')->first();

        $activityTickets = Activity::
        where('subject_type', 'App\Ticket')
        ->where('subject_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

        // foreach ($activityTickets as $activityTicket) {
        //
        //   if (array_key_exists("attributes",$activityTicket->changes()->toArray())){
        //
        //     $statusAll =  Status::find(json_encode($activityTicket->changes['attributes']['status_id']));
        //   }
        //
        // }

        // if (array_key_exists("attributes",$statusAll)) {
        //   // code...
        //
        // }
        ActivityLogger::activity("Viewed Ticket");

        return view('ticket.show', compact('tickets','locations','statuses', 'TicketAgents', 'users','activityTickets', 'next','previous'));

        }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = Auth::user();
      if (Auth::user()->hasRole('admin')) {
        $groups = Group::all();
      }else {
        $groups = Auth::user()->group;
      }
      $ticket = Ticket::findOrfail($id);
      $users = User::all();
      $TicketAgents = $ticket->user;

      $groupId = $ticket->group_id;
          // $users = User::whereHas('group', function ($q) use ($groupId) {
          //     $q->where('group_id', $groupId);
          // })->get();

      $locations = Location::whereHas('group', function ($q) use ($groupId) {
          $q->where('group_id', $groupId);
      })->pluck('location_name','id');
      $categories = Category::whereHas('group', function ($q) use ($groupId) {
          $q->where('group_id', $groupId);
      })->pluck('category_name','id');
      $statuses = Status::all()->pluck('status_name','id');
      //$now = Carbon::now()->addHours(3);


      return view('ticket.edit', compact('ticket','users','locations','categories','statuses','TicketAgents', 'groups'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function storeTicketRating(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'rateScore' => 'required|min:1',
      ]);

      $rateScore = $request->rateScore;
      $ticket_id = $request->ticket_id;

      $rating = new Rating;
      $rating->ticket_id = $ticket_id;
      $rating->rating_value = $rateScore;
      $result = $rating->save();

      if ($result)
      return redirect('ticket/'. $ticket_id)->with('success', 'Rating has been saved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'ticket_title'=>'required',
        'ticket_content'=> 'required',
        'group_id'=> 'required',
        'location_id'=> 'required',
        'category_id'=> 'required',
        'due_date'=> 'date_format:Y-m-d H:i:s|nullable',
      ]);
      $ticket = Ticket::findOrfail($id);
      $ticket->ticket_title = $request->ticket_title;
      $ticket->ticket_content = $request->ticket_content;
      $ticket->location_id = $request->location_id;
      $ticket->category_id = $request->category_id;
      $ticket->group_id = $request->group_id;
      $ticket->status_id = $request->status_id;
      $ticket->priority = $request->priority;
      $ticket->due_date = $request->due_date;
      $ticket->room_number = $request->room_number;
      // $ticket->requested_by = $request->requested_by;
      $graphUserEmail = $request->requested_by;

      if ($request->requested_by){
      $userFinder = User::where('email', $graphUserEmail)->first();
      if(!$userFinder){
        $userFinder = new User;
        $userFinder->name = $request->requested_by_name;
        $userFinder->email = $graphUserEmail;
        $userFinder->password= Hash::make('the-password-of-choice');
        // $user->name= $username;
        // $user->email= $username."@ksau-hs.edu.sa";
        // $user->password= Hash::make('the-password-of-choice');
        $userFinder->save();
        $userFinder->assignRole('enduser');
      }
      
      $ticket->requested_by = $userFinder->id;
    }
      $ticket->save();

    //  $user = $ticket->requested_by_user;
    //  \Mail::to($user)->send(new RequestedBy($user));
      return redirect('/ticket/'.$id)->with('success', 'Ticket has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $ticket = Ticket::findOrfail($id);
      $ticket->delete();
      return redirect('/ticket')->with('success', 'Ticket has been deleted');
    }

    public function restore($id)
    {
      $ticket = Ticket::withTrashed()->where('id', $id)->restore();
      return redirect('/trash')->with('success', 'Ticket has been restored');
    }

    public function addTicketAgent(Request $request)
    {
      $ticket = Ticket::findorfail($request->ticket_id);
      $TicketAgents = $ticket->user;

        if ($TicketAgents->isEmpty()) {
          $ticket->status_id = "4";
          $ticket->save();
        }

      $ticket->user()->syncWithoutDetaching($request->user_id);
      $user = User::findorfail($request->user_id);
      if (App::environment('production')) {
          // The environment is production
          \Mail::to($user)->send(new TicketAgentAssigned($ticket));
      }

      $user->notify(new AssignedTicket($user, $ticket));
      return back();
    }

    // Send Rating Email to the user if the ticket is completed
    public function sendTicketRatingEmail($ticket_id)
    {
      $ticket = Ticket::findorfail($ticket_id);
      $user = User::find($ticket->requested_by_user);
      $TicketAgents = $ticket->user;

      $match = 1;
      foreach ($TicketAgents as $TicketAgent){
        if ($user[0]->id == $TicketAgent->id)
        $match = 0;
      }

      if ($user && $match) {
        if (App::environment('production')) {
            // The environment is production
            \Mail::to($user)->send(new TicketRating($ticket));
        }
      }

      return back();
    }

    /**
     * Remove assigned users to ticket
     *
     */
        public function removeTicketAgent($user_id, $ticket_id)
    {
        $ticket = Ticket::findorfail($ticket_id);
        $ticket->user()->detach($user_id);
        $TicketAgents = $ticket->user;

          if ($TicketAgents->isEmpty()) {
            $ticket->status_id = "3";
            $ticket->save();
          }

        return back();
    }

    public function ChangeTicketStatus($status_id, $tickets_id)
    {
      $ticket = Ticket::findorfail($tickets_id);
      $ticket->status()->associate($status_id);
      $ticket->save();

      $user = User::find($ticket->requested_by_user);

      if ($status_id == "1" && $user) {
        return $this->sendTicketRatingEmail($tickets_id);
      }

      return back();
    }


    public function search(Request $request)
    {
      $user = Auth::user();
    //  $tickets = Ticket::all();
    $groups = Auth::user()->group;
      $userId = $user->id;
      $statuses = Status::all();

      // $userGroups = Auth::user()->group;
      //   foreach ($userGroups as $userGroup) {
      //     $userGroupIDs[] =  $userGroup->id;
      //   };


      if ($user->hasRole('admin')) {

              $findTickets = Ticket::search($request->searchKey)->paginate(10);


          } elseif ($user->hasPermissionTo('view group tickets')) {
            $matching = Ticket::search($request->searchKey)->get()->pluck('id');
            $findTickets = Ticket::whereIn('id', $matching)->orderByRaw('created_at DESC')->simplePaginate(10);


            } else {
              $matching = Ticket::search($request->searchKey)->get()->pluck('id');

                  $findTickets = Ticket::whereHas('user', function ($q) use ($userId) {
                  $q->where('user_id', $userId);})->whereIn('id', $matching)->orderByRaw('created_at DESC')->simplePaginate(10);

          }
          return view('ticket.search', compact('findTickets', 'statuses', 'groups'));

    }

   // Fetch groups by region id
   public function getGroups($region_id){

      $selectedgroups =Group::where('region_id','=',$region_id)
      ->get();
      return response()->json($selectedgroups);
  }

     // Fetch location by group id
     public function getLocations($group_id){

      $selectedlocations =Location::where('group_id','=',$group_id)->get();
      return response()->json($selectedlocations);
  }


     // Fetch category by group id
     public function getCategory($group_id){

      $selectedcategory =Category::where('group_id','=',$group_id)->get();
      return response()->json($selectedcategory);
  }


    public function statusFilter(Request $request)
   {
     $statuses = Status::all();
     if (Auth::user()->hasRole('admin')) {
       $groups = Group::all();
     }else {
       $groups = Auth::user()->group;
     }

     $findTickets = Ticket::where('status_id', $request->status)->orderByRaw('created_at DESC')->simplePaginate(10);

       return view('ticket.search', compact('findTickets', 'statuses', 'groups'));
   }

   public function todayTicket()
   {
     $statuses = Status::all();
     if (Auth::user()->hasRole('admin')) {
       $groups = Group::all();
     }else {
       $groups = Auth::user()->group;
     }

     $findTickets = Ticket::whereDate('due_date', Carbon::now() )->simplePaginate(10);

       return view('ticket.search', compact('findTickets', 'statuses', 'groups'));
   }
  }
