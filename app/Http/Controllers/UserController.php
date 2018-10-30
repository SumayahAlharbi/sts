<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // return view('status.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $status = new Status;
        // $status->status_name = $request->status_name;
        // $status->save();
        // return redirect('/status')->with('success', 'status has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(Users $status)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
     public function edit($id)
     {
       $user = Auth::user();
       // if ($user->hasRole('SuperAdmin')) {
         $user = \App\User::findOrfail($id);
         $roles = Role::all()->pluck('name');
         $userRoles = $user->roles;
         return view('users.edit', compact('user', 'roles', 'userRoles'));
       // }elseif ($user->hasRole('Admin')) {
         // $user = \App\User::whereNotIn('id', [1, 3])->findOrfail($id);
         // $roles = Role::all()->pluck('name');
         // $userRoles = $user->roles;
    //     return view('users.edit', compact('user', 'roles', 'userRoles'));
    // }else{
    //   return abort(401, 'Unauthorized action.');
    // }

     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      {

   //   $this->validate($request, [
   //   'email' => [
   //   'required',
   //   Rule::unique('users')->ignore($request->user_id),
   //    'email',
   //    'max:191',
   //    'string',
   //    'regex:/^[A-Za-z0-9\.]*@(ksau-hs)[.](edu)[.](sa)$/',
   // ],
   //   'name' => 'required|max:191|string',
   //   'password' => 'nullable|between:6,20|string',
   //   ]);
       $user = \App\User::findOrfail($request->user_id);

       $user->email = $request->email;
       $user->name = $request->name;
       if(!empty($request->input('password')))
     {
         $user->password = Hash::make($request->password);
     }


       $user->save();

       return redirect('/users')->with('success', 'user has been updated');
   }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {

       // $users = Status::findOrfail($id);
       // $status->delete();
       // return redirect('/status')->with('success', 'status has been deleted');
     }

     /**
     * Assign Role to user.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function addRole(Request $request)
    {
        $users = User::findOrfail($request->user_id);
        $roles = Role::all()->pluck('name');
        $userRoles = $users->roles;
        $users->assignRole($request->role_name);

        return redirect('users/'.$request->user_id.'/edit');
    }

    /**
     * revoke Role to a a user.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function revokeRole($role, $user_id)
    {
        $users = \App\User::findorfail($user_id);

        $users->removeRole(str_slug($role, ' '));

        return redirect('users/'.$user_id.'/edit');
    }
}
