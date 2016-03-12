<?php

namespace App\Http\Controllers;

use App\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('categories_list')->with([
            'categories' => Category::all()->toHierarchy()
        ]);
    }

    public function show($id = -1)
    {
        return view('categories_list')->with([
            'categories' => Category::find($id)->getDescendantsAndSelf()->toHierarchy()
        ]);
    }

    public function json()
    {
        //return Category::all()->toHierarchy();
        return Category::find(2)->getAncestors()->toHierarchy();
    }
}
