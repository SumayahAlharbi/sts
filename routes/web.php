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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=> 'auth'],function(){


Route::group(['middleware' => ['role:admin']], function () {
  //category Routes
  Route::resource('category','CategoryController');
  //location Routes
  Route::resource('location','LocationController');
  //Users route
  Route::resource('users','UserController');
  //Users status
  Route::resource('status','StatusController');
  //Groups Routes
  Route::resource('group','GroupController');

  Route::resource('permissions','PermissionController');
  Route::resource('roles','RoleController');

  Route::post('users/addRole','\App\Http\Controllers\UserController@addRole');
  Route::get('users/removeRole/{role}/{user_id}','\App\Http\Controllers\UserController@revokeRole');

  // //roles has permissions Routes

  Route::post('roles/addPermission','\App\Http\Controllers\RoleController@addPermission');
  Route::get('roles/removePermission/{permission}/{role_id}','\App\Http\Controllers\RoleController@revokePermission');



// Route::group(['middleware' => ['role:supervisor|admin']], function () {
  // assign agent to a ticket
  Route::post('ticket/addTicketAgent','TicketController@addTicketAgent');
  // remove agent from a ticket
  Route::get('ticket/removeTicketAgent/{user_id}/{ticket_id}','\App\Http\Controllers\TicketController@removeTicketAgent');
// });
});

Route::get('ticket', 'TicketController@index')->name('ticket.index')->middleware('permission:view tickets list');
Route::get('ticket/create', 'TicketController@create')->name('ticket.create')->middleware('permission:create ticket');
Route::post('ticket/create', 'TicketController@store')->name('ticket.store')->middleware('permission:create ticket');
Route::get('ticket/{ticket}', 'TicketController@show')->name('ticket.show')->middleware('permission:show ticket');
Route::get('ticket/{ticket}/edit', 'TicketController@edit')->name('ticket.edit')->middleware('permission:update ticket');
Route::patch('ticket/{ticket}', 'TicketController@update')->name('ticket.update')->middleware('permission:update ticket');
Route::delete('ticket/{ticket}', 'TicketController@destroy')->name('ticket.destroy')->middleware('permission:delete ticket');
Route::get('ticket/ChangeTicketStatus/{status_id}/{ticket_id}','\App\Http\Controllers\TicketController@ChangeTicketStatus')->middleware('permission:change ticket status');


  //Route::resource('ticket','TicketController');


  // Route::post('/ticket/create', 'TicketController@create');
  // Route::get('/ticket/show', 'TicketController@show');


//Comments Routes

Route::post('/comment/store', 'CommentController@store')->name('comment.add');
Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');

// Route::post('ticket/ChangeTicketStatus','\App\Http\Controllers\TicketController@ChangeTicketStatus');
});
