<?php

namespace App\Http\Controllers;

use App\Release;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $releases = Release::all();
        return view('releases.index', compact('releases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('releases.create');

    }

 
    public function store(Request $request)
    {
        
        $release = new Release;
        $release->release_version = $request->release_version;
        $release->release_description = $request->release_description;
        $release->save();
        return redirect('/releases')->with('success', 'release has been added');

    }

    public function show(Release $release)
    {

        $releases = Release::all();
        return view('releases.show', compact('releases'));
        
    }


    public function edit($id)
    {
        
        $releases = Release::find($id);
        return view('releases.edit', compact('releases'));

    }


    public function update(Request $request, $id)
    {
        
        $releases = Release::find($id);
        $releases->release_version = $request->release_version;
        $releases->release_description = $request->release_description;
        $releases->save();

        return redirect('/releases')->with('success', 'release has been updated');

    }


     public function destroy($id)
     {

       $release = Release::findOrfail($id);
       $release->delete();
       return redirect('/releases')->with('success', 'release has been deleted');
     }
}
