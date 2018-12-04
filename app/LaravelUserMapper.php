<?php

namespace App;

use App\User;
use Auth;
Use Exception;

class LaravelUserMapper
{
    public static function map($username)
    {
        $CasUserFullEmail = $username."@ksau-hs.edu.sa";
        // $user = User::where('email', $CasUserFullEmail)->firstOrFail();
        // Auth::login($user);
        // $usercheck = $user; // get user


            try {
                // Validate the value...
                $user = User::where('email', $CasUserFullEmail)->firstOrFail();
                Auth::login($user);
            } catch (Exception $e) {
                report($e);

                return false;
            }


        // if($user){
        //   // log the cas user to his account :)
        //    Auth::login($user);
        //  }
        // return view('welcome');


    }
}
