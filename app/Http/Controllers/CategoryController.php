<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Auth;
use App\Group;

class CategoryController extends Controller
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
      $categories = Category::paginate(10);
      return view('category.index', compact('categories', 'groups'));
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
        return view('category.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $category = new Category;
      $category->category_name = $request->category_name;
      $category->group_id = $request->group_id;
      $category->save();
      return redirect('/category')->with('success', 'Category has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if (Auth::user()->hasRole('admin')) {
        $groups = Group::all();
      }else {
        $groups = Auth::user()->group;
      }
      $category = Category::findOrfail($id);
      return view('category.edit', compact('category', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
      $category = Category::findOrfail($id);
      $category->category_name = $request->category_name;
      $category->group_id = $request->group_id;
      $category->save();

      return redirect('/category')->with('success', 'Category has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
       $category = Category::findOrfail($id);
       $category->delete();
       return redirect('/category')->with('success', 'Category has been deleted');
     }
}
