<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use View;
use Redirect;

class CategoriesController extends Controller
{
    public function index()
    {
        return $this->show(1);
    }

    public function show($id = -1)
    {
        $categories = Category::find($id)->descendantsAndSelf()->orderBy('name')->get()->toHierarchy();

        return View::make('categories.list')->with(compact('categories'));
    }

    public function showAddForm($parent_category_id = -1)
    {
        $category = Category::find($parent_category_id);

        return View::make('categories.submitForm')->with(compact('category', 'parent_category_id'));
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'category_name'   => 'required',
            'parent_category' => 'required',
        ]);

        $parentCategory = Category::find(Input::get('parent_category'));

        if (is_null($parentCategory)) {
            return back();
        }

        $newCategory = $parentCategory->children()->create([
            'parent_id' => Input::get('parent_category'),
            'name'      => Input::get('category_name'),
        ]);

        return Redirect::to($newCategory->getViewLink());
    }
}
