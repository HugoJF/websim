<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Question;
use Validator;

class QuestionsController extends Controller
{
    public function listQuestions() {
        return view('question_list')->with([
            'questions' => Question::with('user')->paginate(10)
        ]);
    }

    public function viewQuestion($id = -1) {
        return view('question')->with([
            'question' => Question::find($id)
        ]);
    }
}
