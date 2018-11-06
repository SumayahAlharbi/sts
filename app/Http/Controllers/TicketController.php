<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Category;
use App\Location;
use App\Status;
use App\User;
use Auth;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        $ticket = Ticket::all();
        if ($user->hasRole('admin')) {
                $tickets = Ticket::paginate(5);
            } else {
                $tickets = $user->ticket;
        }

        return view('ticket.index', compact('tickets'));
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
        return view('ticket.create', compact('categories','locations','users','created_by'));
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
        ]);
        $ticket = new Ticket;

        $ticket->ticket_title = $request->ticket_title;
        $ticket->ticket_content = $request->ticket_content;
        $ticket->category_id = $request->category_id;
        $ticket->location_id = $request->location_id;
        $ticket->status_id = '1';
        $ticket->created_by = $request->created_by;
        $ticket->requested_by = $request->requested_by;

        $ticket->save();
        return redirect('/ticket')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $tickets = Ticket::find($id);
        $statuses = Status::all()->pluck('status_name','id');
        $locations = Location::all()->pluck('location_name','id');
        return view('ticket.show', compact('tickets','locations','statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $ticket = Ticket::find($id);
      $users = \App\User::all();
      $TicketAgents = $ticket->user;
      $locations = Location::all()->pluck('location_name','id');
      $categories = Category::all()->pluck('category_name','id');
      $statuses = Status::all()->pluck('status_name','id');
      return view('ticket.edit', compact('ticket','users','locations','categories','statuses','TicketAgents'));

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
      $ticket->status_id = $request->status_id;
      $ticket->requested_by = $request->requested_by;
      $ticket->save();

      return redirect('/ticket')->with('success', 'Ticket has been updated');
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
      return redirect('ticket/'.$request->ticket_id. '/edit');
    }
    /**
     * Remove assigned users to ticket
     *
     */
        public function removeTicketAgent($user_id, $ticket_id)
    {
        $ticket = Ticket::findorfail($ticket_id);

        $ticket->user()->detach($user_id);

        return redirect('ticket/'.$ticket_id.'/edit');
    }

    public function ChangeTicketStatus($status_id, $tickets_id)
    {
      $ticket = Ticket::findorfail($tickets_id);
      $ticket->status()->associate($status_id);
      $ticket->save();


      // $account = App\Account::find(10);


      //
      // $user->save();

      return redirect('ticket/'.$tickets_id);
    }



}
