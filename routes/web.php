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
//category Routes
Route::resource('category','CategoryController');
//location Routes
Route::resource('location','LocationController');
//Status route
Route::resource('status','StatusController');
//Users route
Route::resource('users','UserController');

// assign agent to a ticket
Route::post('ticket/addTicketAgent','TicketController@addTicketAgent');
// remove agent from a ticket
Route::get('ticket/removeTicketAgent/{user_id}/{ticket_id}','\App\Http\Controllers\TicketController@removeTicketAgent');

//Groups Routes
Route::resource('group','GroupController');

Route::resource('permissions','PermissionController');
Route::resource('roles','RoleController');

Route::post('users/addRole','\App\Http\Controllers\UserController@addRole');
Route::get('users/removeRole/{role}/{user_id}','\App\Http\Controllers\UserController@revokeRole');

//roles has permissions Routes
Route::group(['middleware'=> 'web'],function(){
  Route::post('roles/addPermission','\App\Http\Controllers\RoleController@addPermission');
  Route::get('roles/removePermission/{permission}/{role_id}','\App\Http\Controllers\RoleController@revokePermission');
});
