<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class CalendarController extends Controller
{
    public function index()
    {
        // $tickets = Ticket::all('due_date');
        $tickets = Ticket::where('due_date', '!=' , null)->get();
        return view('calendar.index', compact('tickets'));
    }
}
