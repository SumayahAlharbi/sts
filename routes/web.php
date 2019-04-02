<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
// Route::get('/welcome', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('test', function () {
    event(new App\Events\TicketAssigned('Someone'));
    return "Event has been sent!";
});

// CAS Login
Route::get('/cas/login', function(){
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
        return redirect()->route('home');
      // if the user is authenticated by CAS and not found by user maper in the app :(
      }elseif (!(Auth::check())) {
        // See ya !
        abort(403, 'Access Denied, Your KSAU-HS account is correct but you don not have access to this application.');
      }
    }
})->name('cas');

// CAS Logout
Route::get('/cas/logout', function(){
      cas()->logout();
});

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware'=> 'auth'],function(){

// Show User Profile
  Route::get('/profile/{id}', '\App\Http\Controllers\UserController@showUserProfile')
  ->name('profile.show');

// Email HTML Viewer
  Route::get('/email', function () {
      $user = App\user::find(1);

      return new App\Mail\RequestedBy($user);
  });

  Route::get('/assign', function () {
    $agentticket = App\ticket::find(2);

    return new App\Mail\TicketAgentAssigned($agentticket);
});

// Email HTML Viewer layout
Route::get('/emaillayout', function(){
      return view('emails.emaillayout');
});

Route::group(['middleware' => ['role:admin']], function () {
  //category Routes
  Route::resource('category','CategoryController');
  //location Routes
  Route::resource('location','LocationController');
  //Users route
  Route::resource('users','UserController');
  // assign user to a group
  Route::post('users/addUserGroup','UserController@addUserGroup');
  Route::get('users/removeUserGroup/{user_id}/{group_id}','\App\Http\Controllers\UserController@removeUserGroup');
  //Users status
  Route::resource('status','StatusController');
  //Groups Routes
  Route::resource('group','GroupController');

  Route::resource('permissions','PermissionController');
  Route::resource('roles','RoleController');

  Route::post('users/addRole','\App\Http\Controllers\UserController@addRole');
  Route::get('users/removeRole/{role}/{user_id}','\App\Http\Controllers\UserController@revokeRole');

  // Add Permission to a user
  Route::post('users/addPermission','\App\Http\Controllers\UserController@addPermission');
  Route::get('users/removePermission/{permission}/{user_id}','\App\Http\Controllers\UserController@revokePermission');

   //roles has permissions Routes

  Route::post('roles/addPermission','\App\Http\Controllers\RoleController@addPermission');
  Route::get('roles/removePermission/{permission}/{role_id}','\App\Http\Controllers\RoleController@revokePermission');

  //category Routes
  Route::resource('activity','ActivityController');

// Route::group(['middleware' => ['role:supervisor|admin']], function () {

// });
});

Route::get('ticket', 'TicketController@index')->name('ticket.index')->middleware('permission:view tickets list');
Route::get('ticket/create', 'TicketController@create')->name('ticket.create')->middleware('permission:create ticket');
Route::post('ticket', 'TicketController@store')->name('ticket.store')->middleware('permission:create ticket');
// Route::post('ticket/create', 'TicketController@store')->name('ticket.store')->middleware('permission:create ticket');
Route::get('ticket/{ticket}', 'TicketController@show')->name('ticket.show')->middleware('permission:show ticket');
Route::get('ticket/{ticket}/edit', 'TicketController@edit')->name('ticket.edit')->middleware('permission:update ticket');
Route::patch('ticket/{ticket}', 'TicketController@update')->name('ticket.update')->middleware('permission:update ticket');
Route::delete('ticket/{ticket}', 'TicketController@destroy')->name('ticket.destroy')->middleware('permission:delete ticket');
Route::get('ticket/ChangeTicketStatus/{status_id}/{ticket_id}','\App\Http\Controllers\TicketController@ChangeTicketStatus')->middleware('permission:change ticket status');
Route::get('/search', 'TicketController@search')->name('ticket.search');

// assign agent to a ticket
Route::post('ticket/addTicketAgent','TicketController@addTicketAgent')->middleware('permission:assign ticket');
// remove agent from a ticket
Route::get('ticket/removeTicketAgent/{user_id}/{ticket_id}','\App\Http\Controllers\TicketController@removeTicketAgent')->middleware('permission:unassign ticket');

  //Route::resource('ticket','TicketController');


  // Route::post('/ticket/create', 'TicketController@create');
  // Route::get('/ticket/show', 'TicketController@show');

// Reports
Route::resource('reports','ReportController')->middleware('permission:export tickets');
Route::post('reports/display','ReportController@displayReport')->middleware('permission:export tickets');


//Comments Routes

Route::post('/comment/store', 'CommentController@store')->name('comment.add');
Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');

// Route::post('ticket/ChangeTicketStatus','\App\Http\Controllers\TicketController@ChangeTicketStatus');
});
