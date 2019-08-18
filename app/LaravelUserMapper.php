<?php

namespace App;

use App\User;
use Auth;
Use Exception;
use Illuminate\Support\Facades\Hash;

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
                //if (Auth::user()->role->isEmpty()) {
                //     $user()->addRole('enduser');
                //     Auth::login($user);
                // }
                // else{
                    
                // }
                
            } catch (Exception $e) {

                //user not found in the databse..register new user from cas
                $user = new User;
                $user->name= $username;
                $user->email= $username."@ksau-hs.edu.sa";
                $user->password= Hash::make('the-password-of-choice');
                $user->save();

                //all new users  gets enduser role
                $user->assignRole('enduser');

                // these permissions required for end-user to access and create tickets
                $user->givePermissionTo('show ticket');
                $user->givePermissionTo('view tickets list');
                $user->givePermissionTo('End User Create Ticket');
                
                //report($e);

                //return false;
                Auth::login($user);
            
                

                
            }


        // if($user){
        //   // log the cas user to his account :)
        //    Auth::login($user);
        //  }
        // return view('welcome');


    }
}
