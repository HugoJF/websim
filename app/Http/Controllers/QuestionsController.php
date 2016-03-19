<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;

class QuestionsController extends Controller
{
    public function listAllQuestions()
    {
        return view('question_list')->with([
            'questions' => Question::with('user', 'votes', 'answers')->paginate(10),
        ]);
    }

    public function viewQuestion($id = -1)
    {
        return view('question')->with([
            'question' => Question::find($id),
        ]);
    }

    public function category($category_id = -1)
    {
        $categories = Category::find($category_id)->getDescendantsAndSelf()->pluck('id');

        //return Question::with('user')->whereIn('category_id', $categories)->paginate(10);
        return view('question_list')->with([
            'questions' => Question::with('user')->whereIn('category_id', $categories)->paginate(10)
        ]);
    }
}
