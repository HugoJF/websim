<?php

namespace App\Http\Controllers;

use App\Answer;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AnswersController extends Controller
{
    public function index()
    {
        return view('answers_list')->with([
            'answers' => Answer::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function submit(Request $request)
    {
        if (!Auth::user()->canAnswerQuestions()) {
            return 'You can\'t answer more questions today';
        }
        $this->validate($request, [
            'answer'      => 'required',
            'question_id' => 'required',
            'attempt_id'  => 'required',
            'test_id'     => 'required',
            'user_id'     => 'required',
        ]);

        if (Input::get('user_id') != Auth::user()->id) {
            return 'Error: you\'re trying to create an answer for another user';
        }

        \Debugbar::info(Input::all());

        $answer = new Answer();

        $answer->fill(Input::all());

        $answer->save();

        if ($answer->test_id == null) {
            return redirect()->route('questionsView', ['question_id' => $answer->question_id]);
        } else {
            return redirect()->route('attemptsContinue', ['attempt_id' => $answer->attempt_id]);
        }
    }
}
