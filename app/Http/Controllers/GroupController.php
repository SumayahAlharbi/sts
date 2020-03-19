<?php

namespace App\Http\Controllers;

use App\Group;
use App\Region;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $groups = group::paginate(10);
        return view('group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = region::get();
          return view('group.create', compact('regions'));
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
        $request->validate([
          'group_name'=>'required',
          'group_description'=> 'required',
          'region_id'=>'required',
          'email'=>'required',
          
        ]);

        $group = new group;

        $group->group_name = $request->group_name;
        $group->group_description = $request->group_description;
        $group->region_id = $request->region_id;
        $group->email = $request->email;
        $group->save();
        return redirect('/group')->with('success', 'Group has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $group = group::find($id);
        // $group->settings()->delete('email');
        $regions = region::get();
        return view('group.edit', compact('group','regions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $group = group::find($id);
        $group->group_name = $request->group_name;
        $group->region_id = $request->region_id; // to assign region to a group and update it
        $group->group_description = $request->group_description;
        $group->email = $request->email;
        $group->save();

        return redirect('/group')->with('success', 'group has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
       $group = Group::findOrfail($id);
       $group->delete();
       return redirect('/group')->with('success', 'Group has been deleted');
     }
    public function changeGroupVisibilty($groupId, $settingValue)
{
    $group = Group::findOrFail($groupId);
    $group->visibility_id = $settingValue;
    $group->save();

    return response()->json(['message' => 'Setting updated successfully.']);
}
public function changeGroupSetting(Request $request)
{
    $group = Group::findOrFail($request->group_id);
    $group->settings()->set($request->setting_name, $request->setting_value);
    $groupId = $group->id;
    $settingValue = $request->setting_value;
    if ($request->setting_name == 'allow_enduser_ticket') {
        $this->changeGroupVisibilty($groupId, $settingValue);
    }
    
    return response()->json(['message' => 'Setting updated successfully.']);
}
}
