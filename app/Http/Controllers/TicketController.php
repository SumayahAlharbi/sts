<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Category;
use App\Location;
use App\Status;
use App\Group;
use App\User;
use Auth;
use App\Mail\agent;
use App\Mail\TicketAgentAssigned;
use App\Mail\RequestedBy;

use Illuminate\Http\Request;

class TicketController extends Controller
{
//   public function __construct()
// {
//   // $this->middleware('role:admin')->only('index','show');
//   $this->middleware('role:admin', ['except' => ['index', 'show', 'ChangeTicketStatus']]);
//
// }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        $tickets = Ticket::all();
        $userId = $user->id;
        $statuses = Status::all();

        if ($user->hasRole('admin')) {
                $tickets = Ticket::orderByRaw('updated_at DESC')->get();
            } else {
              $tickets = Ticket::whereHas('user', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->orderByRaw('updated_at DESC')->get();

        }

        return view('ticket.index', compact('tickets', 'statuses'));
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
        $users = User::all()->pluck('name','id');
        $created_by = Auth::user();
        $groups = $created_by->group;
        return view('ticket.create', compact('categories','locations','users','created_by', 'groups'));
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
        ]);
        $ticket = new Ticket;

        $ticket->ticket_title = $request->ticket_title;
        $ticket->ticket_content = $request->ticket_content;
        $ticket->category_id = $request->category_id;
        $ticket->location_id = $request->location_id;
        $ticket->group_id = $request->group_id;
        $ticket->status_id = '3';
        $ticket->priority = $request->priority;
        $ticket->room_number = $request->room_number;
        $ticket->created_by = $request->created_by;
        $ticket->requested_by = $request->requested_by;

        $ticket->save();
        $user = $ticket->requested_by_user;
        \Mail::to($user)->send(new RequestedBy($user));
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
        $user = Auth::user();
        $users = \App\User::all();
        $ticket =  Ticket::findOrfail($id);
        $TicketAgents = $ticket->user;
        $statuses = Status::all()->pluck('status_name','id');
        $locations = Location::all()->pluck('location_name','id');
        $tickets =  Ticket::find($id);

        if ($user->hasRole('admin')) {
        return view('ticket.show', compact('tickets','locations','statuses', 'TicketAgents', 'ticket','users'));
      }
        else {
          foreach ($TicketAgents as $TicketAgent) {
            if ($user->id == $TicketAgent->id) {
              return view('ticket.show', compact('tickets','locations','statuses', 'TicketAgents', 'ticket','users'));
            }
              }

          }
          if ($user->id != $TicketAgent->id) {
                return redirect('/ticket')->with('danger', 'You do not have access to this ticket!');
              }
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
      $groups = $user->group;
      $ticket = Ticket::find($id);
      $users = \App\User::all();
      $TicketAgents = $ticket->user;
      $locations = Location::all()->pluck('location_name','id');
      $categories = Category::all()->pluck('category_name','id');
      $statuses = Status::all()->pluck('status_name','id');

      if ($user->hasRole('admin')) {
        return view('ticket.edit', compact('ticket','users','locations','categories','statuses','TicketAgents', 'groups'));
    }
      else {
        foreach ($TicketAgents as $TicketAgent) {
          if ($user->id == $TicketAgent->id) {
            return view('ticket.edit', compact('ticket','users','locations','categories','statuses','TicketAgents', 'groups'));
          }
            }

        }
        if ($user->id != $TicketAgent->id) {
              return redirect('/ticket')->with('danger', 'You do not have access to this ticket!');
            }


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
      $ticket = Ticket::findOrfail($id);
      $ticket->ticket_title = $request->ticket_title;
      $ticket->ticket_content = $request->ticket_content;
      $ticket->location_id = $request->location_id;
      $ticket->category_id = $request->category_id;
      $ticket->group_id = $request->group_id;
      $ticket->status_id = $request->status_id;
      $ticket->priority = $request->priority;
      $ticket->room_number = $request->room_number;
      $ticket->requested_by = $request->requested_by;
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

    public function addTicketAgent(Request $request)
    {

      $ticket = Ticket::findorfail($request->ticket_id);
      $ticket->user()->syncWithoutDetaching($request->user_id);
      $user = User::findorfail($request->user_id);

      // \Mail::to($user)->send(new TicketAgentAssigned);
      \Mail::to($user)->send(new TicketAgentAssigned($ticket));

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

        return back();
    }

    public function ChangeTicketStatus($status_id, $tickets_id)
    {
      $ticket = Ticket::findorfail($tickets_id);
      $ticket->status()->associate($status_id);
      $ticket->save();


      // $account = App\Account::find(10);


      //
      // $user->save();

      return back();
    }



}
