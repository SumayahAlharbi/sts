<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Auth;
use App\Group;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Auth::user()->hasRole('admin')) {
        $groups = Group::all();
      }else {
        $groups = Auth::user()->group;
      }

      $locations = Location::paginate(10);
      return view('location.index', compact('locations', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if (Auth::user()->hasRole('admin')) {
        $groups = Group::all();
      }else {
        $groups = Auth::user()->group;
      }
        return view('location.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $location = new Location;
      $location->location_name = $request->location_name;
      $location->location_description = $request->location_description;
      $location->group_id = $request->group_id;
      $location->save();
      return redirect('/location')->with('success', 'Location has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      if (Auth::user()->hasRole('admin')) {
        $groups = Group::all();
      }else {
        $groups = Auth::user()->group;
      }
      $location = Location::findOrfail($id);

      return view('location.edit', compact('location', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $location = Location::findOrfail($id);
      $location->location_name = $request->location_name;
      $location->location_description = $request->location_description;
      $location->group_id = $request->group_id;
      $location->save();

      return redirect('/location')->with('success', 'location has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
       $location = Location::findOrfail($id);
       $location->delete();
       return redirect('/location')->with('success', 'Location has been deleted');
     }
}
