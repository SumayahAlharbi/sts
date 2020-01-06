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

Route::get('/welcome', 'WelcomeController@welcome');

Route::get('/signin', 'Auth\MsGraphLoginController@signin');
Route::get('/callback', 'Auth\MsGraphLoginController@callback');
Route::get('/signout', 'Auth\MsGraphLoginController@signout');
// Route::get('/userslist', 'auth\MsGraphLoginController@usersList');
Route::get('/userslist', 'Auth\MsGraphLoginController@usersList')->name('graph.users.list');

Auth::routes();

// Route::get('test', function () {
//     event(new App\Events\TicketAssigned('Someone'));
//     return "Event has been sent!";
// });

Route::get('/redirect/graph', 'Auth\LoginController@redirectToProvider');
Route::get('/callback/graph', 'Auth\LoginController@handleProviderCallback');

Route::get('total-tickets-api', 'HomeController@TicketsChartsApi');

// // CAS Login
// Route::get('/cas/login', function(){
//   // if the user isn't authenticated by CAS
//   if ( !cas()->isAuthenticated() ) {
//     // take the user to CAS
//     cas()->authenticate();
//     }
//     // if the user is authenticated by CAS
//     if ( cas()->isAuthenticated() ) {
//       // if the user is authenticated by CAS and found by user maper and matched a existing account
//       if (Auth::check()) {
//         // he shall enter :)
//         return redirect()->intended('/');;
//       // if the user is authenticated by CAS and not found by user maper in the app :(
//       }elseif (!(Auth::check())) {
//         // See ya !
//         abort(403, 'Access Denied, Your KSAU-HS account is correct but you don not have access to this application.');
//       }
//     }
// })->name('cas');

// CAS Login 2.0
Route::get('/cas/login', 'CasController@CasLogin')->name('cas');

// // CAS Logout
// Route::get('/cas/logout', function(){
//       cas()->logout();
// });

// CAS Logout 2.0
Route::get('/cas/logout', 'CasController@CasLogout');

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

  Route::get('/notifications', 'UserController@notifications');

  // Show User Profile
  Route::get('/profile/{id}', '\App\Http\Controllers\UserController@showUserProfile')
    ->name('profile.show');
  Route::get('/profileSearch', 'UserController@profileSearch')->name('user.profileSearch');
  Route::get('/userSearch', 'UserController@userSearch')->name('user.userSearch');

  // // Email HTML Viewer
  //   Route::get('/email', function () {
  //       $user = App\user::find(1);

  //       return new App\Mail\RequestedBy($user);
  //   });

  //   Route::get('/assign', function () {
  //     $agentticket = App\ticket::find(1);

  //     return new App\Mail\TicketAgentAssigned($agentticket);
  // });

  // // Email HTML Viewer layout
  // Route::get('/emaillayout', function(){
  //   return view('emails.emaillayout');
  // });

  Route::group(['middleware' => ['role:admin']], function () {


    //Users route
    Route::resource('users', 'UserController');
    // assign user to a group
    Route::post('users/addUserGroup', 'UserController@addUserGroup');
    Route::get('users/removeUserGroup/{user_id}/{group_id}', '\App\Http\Controllers\UserController@removeUserGroup');
    //Users status
    Route::resource('status', 'StatusController');
    //Groups Routes
    Route::resource('group', 'GroupController');
    //Groups Settings
    Route::get('/changeGroupVisibilty', 'GroupController@changeGroupVisibilty')->name('group.change.visibility');
    Route::get('/changeAssignedEmail', 'GroupController@changeAssignedEmail')->name('group.change.assignemail');
    Route::get('/changeDepartmentalEmail', 'GroupController@changeDepartmentalEmail')->name('group.change.departmentalemail');
    Route::get('/changeGroupSetting', 'GroupController@changeGroupSetting')->name('group.change.setting');




    //Releases
    Route::resource('releases', 'ReleaseController');

    //Regions Routes
    //Route::resource('regions','RegionController');
    Route::get('regions/create', 'RegionController@create')->name('regions.create');
    Route::post('regions', 'RegionController@store')->name('regions.store');
    Route::post('regions/create', 'RegionController@store')->name('regions.store');
    //Route::get('regions/{regions}', 'RegionController@show')->name('regions.show');
    Route::get('regions/{regions}/edit', 'RegionController@edit')->name('regions.edit');
    Route::patch('regions/{regions}', 'RegionController@update')->name('regions.update');
    Route::delete('regions/{regions}', 'RegionController@destroy')->name('regions.destroy');

    Route::resource('permissions', 'PermissionController');
    Route::resource('roles', 'RoleController');

    Route::post('users/addRole', '\App\Http\Controllers\UserController@addRole');
    Route::get('users/removeRole/{role}/{user_id}', '\App\Http\Controllers\UserController@revokeRole');

    // Add Permission to a user
    Route::post('users/addPermission', '\App\Http\Controllers\UserController@addPermission');
    Route::get('users/removePermission/{permission}/{user_id}', '\App\Http\Controllers\UserController@revokePermission');

    //roles has permissions Routes

    Route::post('roles/addPermission', '\App\Http\Controllers\RoleController@addPermission');
    Route::get('roles/removePermission/{permission}/{role_id}', '\App\Http\Controllers\RoleController@revokePermission');


    //Activity Routes
    // Route::resource('activity','ActivityController');

    // Route::group(['middleware' => ['role:supervisor|admin']], function () {

    // });
  });

  Route::get('/changeUserSetting', 'UserController@changeUserSetting')->name('user.change.setting');
  
  //Regions Routes
  Route::get('regions', 'RegionController@index')->name('regions.index');


  Route::get('getGroups/{cat_id}', 'TicketController@getGroups');
  Route::get('getLocations/{cat_id}', 'TicketController@getLocations');
  Route::get('getCategory/{cat_id}', 'TicketController@getCategory');

  //category Routes
  //Route::resource('category','CategoryController');
  Route::get('category', 'CategoryController@index')->name('category.index')->middleware('permission:view category list');
  Route::get('category/create', 'CategoryController@create')->name('category.create')->middleware('permission:create category');
  Route::post('category', 'CategoryController@store')->name('category.store')->middleware('permission:create category');
  Route::post('category/create', 'CategoryController@store')->name('category.store')->middleware('permission:create category');
  //Route::get('category/{category}', 'CategoryController@show')->name('category.show')->middleware('permission:show category');
  Route::get('category/{category}/edit', 'CategoryController@edit')->name('category.edit')->middleware('permission:update category');
  Route::patch('category/{category}', 'CategoryController@update')->name('category.update')->middleware('permission:update category');
  Route::delete('category/{category}', 'CategoryController@destroy')->name('category.destroy')->middleware('permission:delete category');

  //location Routes
  //Route::resource('location','LocationController');
  Route::get('location', 'LocationController@index')->name('location.index')->middleware('permission:view location list');
  Route::get('location/create', 'LocationController@create')->name('location.create')->middleware('permission:create location');
  Route::post('location', 'LocationController@store')->name('location.store')->middleware('permission:create location');
  Route::post('location/create', 'LocationController@store')->name('location.store')->middleware('permission:create location');
  //Route::get('location/{location}', 'LocationController@show')->name('location.show')->middleware('permission:show location');
  Route::get('location/{location}/edit', 'LocationController@edit')->name('location.edit')->middleware('permission:update location');
  Route::patch('location/{location}', 'LocationController@update')->name('location.update')->middleware('permission:update location');
  Route::delete('location/{location}', 'LocationController@destroy')->name('location.destroy')->middleware('permission:delete location');


  Route::get('ticket', 'TicketController@index')->name('ticket.index')->middleware('permission:view tickets list');
  Route::get('ticket/create', 'TicketController@create')->name('ticket.create')->middleware('permission:create ticket');
  Route::post('ticket', 'TicketController@store')->name('ticket.store')->middleware('permission:create ticket');
  Route::post('ticket/store', 'TicketController@Enduserstore')->name('ticket.Enduserstore')->middleware('permission:end user create ticket');
  // Route::post('ticket/create', 'TicketController@store')->name('ticket.store')->middleware('permission:create ticket');
  Route::get('ticket/{ticket}', 'TicketController@show')->name('ticket.show')->middleware('permission:show ticket');
  Route::get('ticket/{ticket}/edit', 'TicketController@edit')->name('ticket.edit')->middleware('permission:update ticket');
  Route::get('ticket/{ticket}/rate', 'TicketController@rate')->name('ticket.rate');
  Route::patch('ticket/{ticket}', 'TicketController@update')->name('ticket.update')->middleware('permission:update ticket');
  Route::delete('ticket/{ticket}', 'TicketController@destroy')->name('ticket.destroy')->middleware('permission:delete ticket');
  Route::get('ticket/ChangeTicketStatus/{status_id}/{ticket_id}', '\App\Http\Controllers\TicketController@ChangeTicketStatus')->middleware('permission:change ticket status');
  Route::get('ticket/ChangeTicketTotal/{user_id}/{setting_value}', '\App\Http\Controllers\TicketController@ChangeTicketTotal');
  Route::get('/search', 'TicketController@search')->name('ticket.search');
  Route::get('/statusFilter', 'TicketController@statusFilter')->name('ticket.statusFilter');
  Route::get('/groupFilter', 'TicketController@groupFilter')->name('ticket.groupFilter');
  Route::get('/todayTicket', 'TicketController@todayTicket')->name('ticket.todayTicket');
  Route::get('/lateTicket', 'TicketController@lateTicket')->name('ticket.lateTicket');
  // assign agent to a ticket
  Route::post('ticket/storeTicketRating', 'TicketController@storeTicketRating');
  // store ticket rating
  Route::post('ticket/addTicketAgent', 'TicketController@addTicketAgent')->middleware('permission:assign ticket');
  // remove agent from a ticket
  Route::get('ticket/removeTicketAgent/{user_id}/{ticket_id}', '\App\Http\Controllers\TicketController@removeTicketAgent')->middleware('permission:unassign ticket');

  //trashed tickets route
  Route::get('trash', 'TicketController@deletedTickets')->name('ticket.trash')->middleware('permission:view trashed tickets');
  Route::get('trash/{ticket}/restore', 'TicketController@restore')->name('ticket.restore')->middleware('permission:restore ticket');

  //Route::resource('ticket','TicketController');


  // Route::post('/ticket/create', 'TicketController@create');
  // Route::get('/ticket/show', 'TicketController@show');

  // Exports
  Route::resource('Exports', 'ExportController')->middleware('permission:export tickets');
  Route::post('export/display', 'ExportController@displayReport')->middleware('permission:export tickets');


  //Comments Routes

  Route::post('/comment/store', 'CommentController@store')->name('comment.add');
  Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');
  Route::delete('/comment/destroyComment/{comment}', 'CommentController@destroyComment')->name('comment.destroyComment');
  // Route::post('ticket/ChangeTicketStatus','\App\Http\Controllers\TicketController@ChangeTicketStatus');
});
