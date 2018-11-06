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

//Tickets Routes
Route::resource('ticket','TicketController')->middleware('auth');

Route::group(['middleware' => ['role:admin']], function () {
  //category Routes
  Route::resource('category','CategoryController')->middleware('auth');
  //location Routes
  Route::resource('location','LocationController')->middleware('auth');
  //Users route
  Route::resource('users','UserController')->middleware('auth');
  //Users status
  Route::resource('status','StatusController')->middleware('auth');
  //Groups Routes
  Route::resource('group','GroupController')->middleware('auth');

  Route::resource('permissions','PermissionController')->middleware('auth');
  Route::resource('roles','RoleController')->middleware('auth');

  Route::post('users/addRole','\App\Http\Controllers\UserController@addRole');
  Route::get('users/removeRole/{role}/{user_id}','\App\Http\Controllers\UserController@revokeRole');

  // //roles has permissions Routes
  Route::group(['middleware'=> 'auth'],function(){
  Route::post('roles/addPermission','\App\Http\Controllers\RoleController@addPermission');
  Route::get('roles/removePermission/{permission}/{role_id}','\App\Http\Controllers\RoleController@revokePermission');
  });
});

// Route::group(['middleware' => ['role:supervisor|admin']], function () {
  // assign agent to a ticket
  Route::post('ticket/addTicketAgent','TicketController@addTicketAgent')->middleware('auth');
  // remove agent from a ticket
  Route::get('ticket/removeTicketAgent/{user_id}/{ticket_id}','\App\Http\Controllers\TicketController@removeTicketAgent')->middleware('auth');
// });



Route::post('/comment/store', 'CommentController@store')->name('comment.add');
Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');

Route::get('ticket/ChangeTicketStatus/{status_id}/{ticket_id}','\App\Http\Controllers\TicketController@ChangeTicketStatus');
// Route::post('ticket/ChangeTicketStatus','\App\Http\Controllers\TicketController@ChangeTicketStatus');
