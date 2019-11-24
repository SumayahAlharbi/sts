<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

   
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /** Redirect to the provided request */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return $redirectTo;
        }
    
        return $next($request);
    }

    public function redirectToProvider()
    {
        return Socialite::with('graph')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $msGraphUser = Socialite::driver('graph')->user();

        $user = $this->userFindorCreate($msGraphUser);

        Auth::login($user, true);

        return redirect()->intended();
        // $user->token;
        // OAuth Two Providers
// $token = $user->token;
// $refreshToken = $user->refreshToken; // not always provided
// $expiresIn = $user->expiresIn;

// // OAuth One Providers
// $token = $user->token;
// $tokenSecret = $user->tokenSecret;

// All Providers
$user->getId();
$user->getNickname();
$user->getName();
$user->getEmail();
$user->getAvatar();
    }

    public function userFindorCreate($msGraphUser){
        $user = User::where('email', $msGraphUser->getEmail())->first();

        if(!$user){
            $user = new User;
        $user->name = $msGraphUser->getName();
        $user->email = $msGraphUser->getEmail();
        $user->password= Hash::make('the-password-of-choice');

        // $user->name= $username;
        // $user->email= $username."@ksau-hs.edu.sa";
        // $user->password= Hash::make('the-password-of-choice');

        $user->save();

        $user->assignRole('enduser');
        }
        return $user;
    }

}
