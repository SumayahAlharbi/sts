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
// Route::post('/ticket/create','TicketController@create');

//Status route
Route::resource('status','StatusController');


//Groups Routes
Route::resource('group','GroupController');

  Route::resource('/roles','RoleController');
  Route::resource('permissions','PermissionController');
Route::resource('roles','RoleController');


//roles has permissions Routes
Route::group(['middleware'=> 'web'],function(){
  Route::post('roles/addPermission','\App\Http\Controllers\RoleController@addPermission');
  Route::get('roles/removePermission/{permission}/{role_id}','\App\Http\Controllers\RoleController@revokePermission');
});
