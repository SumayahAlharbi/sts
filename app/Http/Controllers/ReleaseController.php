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
        return view('release.index', compact('releases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('release.create');

    }

 
    public function store(Request $request)
    {
        
        $release = new Release;
        $release->release_version = $request->release_version;
        $release->save();
        return redirect('/release')->with('success', 'release has been added');

    }

    public function show(Release $release)
    {

        $releases = Release::all();
        return view('release.show', compact('releases'));
        
    }


    public function edit($id)
    {
        
        $release = Release::find($id);
        return view('release.edit', compact('releases'));

    }


    public function update(Request $request, $id)
    {
        
        $release = Release::find($id);
        $release->release_version = $request->release_version;
        $release->save();

        return redirect('/release')->with('success', 'release has been updated');

    }


     public function destroy($id)
     {

       $release = Release::findOrfail($id);
       $release->delete();
       return redirect('/release')->with('success', 'release has been deleted');
     }
}
