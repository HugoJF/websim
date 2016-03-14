<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoriesController extends Controller
{
    public function index()
    {
        return $this->show(1);
    }

    public function show($id = -1)
    {
        return view('categories_list')->with([
            'categories' => Category::find($id)->getDescendantsAndSelf()->toHierarchy(),
        ]);
    }

    public function json()
    {
        //return Category::all()->toHierarchy();
        return Category::find(1)->getImmediateDescendants()->toHierarchy();
    }

    public function showAddForm($category_id = -1)
    {
        return view('add_category')->with([
            'category'           => Category::find($category_id),
            'parent_category_id' => $category_id
        ]);
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'category_name'  => 'required',
            'parent_category'=> 'required',
        ]);

        \Debugbar::info(Input::all());

        $parentCategory = Category::find(Input::get('parent_category'));

        if($parentCategory == null) {
            return back();
        }

        $newCategory = $parentCategory->children()->create([
            'parent_id' => Input::get('parent_category'),
            'name'      => Input::get('category_name'),
        ]);

        return redirect($newCategory->getViewLink());

    }
}
