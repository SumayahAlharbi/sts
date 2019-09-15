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

class CasController extends Controller
{
    public function CasLogin()
    {
        // if the user isn't authenticated by CAS
  if ( !cas()->isAuthenticated() ) {
    // take the user to CAS
    cas()->authenticate();
    }
    // if the user is authenticated by CAS
    if ( cas()->isAuthenticated() ) {
      // if the user is authenticated by CAS and found by user maper and matched a existing account
      if (Auth::check()) {
        // he shall enter :)
        return redirect()->intended('/');;
      // if the user is authenticated by CAS and not found by user maper in the app :(
      }elseif (!(Auth::check())) {
        // See ya !
        abort(403, 'Access Denied, Your KSAU-HS account is correct but you don not have access to this application.');
      }
    }
}
public function CasLogout()
{
  cas()->logout();
}

}
