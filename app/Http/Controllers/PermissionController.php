<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create(['name' => $request->name]);

        return redirect('permissions');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Permission = Permission::findOrFail($id);
        $permissions = Permission::all()->pluck('name');
        // $userPermissions = $user->Permissions;
        $PermissionPermissions = $Permission->permissions;

        return view('Permissions.edit', compact('Permission','permissions','PermissionPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Permission = Permission::findOrFail($request->Permission_id);

        $Permission->name = $request->name;

        $Permission->update();

        return redirect('Permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Permission = Permission::findOrFail($id);

        $Permission->delete();

        return redirect('Permissions');
    }

    /**
     * Assign Permission to a Permission.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function addPermission(Request $request)
    {
        $Permission = Permission::findOrFail($request->Permission_id);
        $Permission->givePermissionTo($request->permission_name);

        return redirect('Permissions/edit/'.$request->Permission_id);
    }

        /**
     * revoke Permission to a user.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function revokePermission($permission, $Permission_id)
    {
        $Permission = Permission::findorfail($Permission_id);

        $Permission->revokePermissionTo(str_slug($permission, ' '));

        return redirect('Permissions/edit/'.$Permission_id);
    }

}
