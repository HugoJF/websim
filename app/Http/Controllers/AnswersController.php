<?php

namespace App\Http\Controllers;

use App\Answer;
use Auth;
use View;
use Session;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AnswersController extends Controller
{
    public function index()
    {
        $answers = Answer::where('user_id', Auth::id())->get();

        return View::make('answers.list')->with(compact('answers'));
    }

    public function submit(Request $request)
    {
        if (!Auth::user()->canAnswerQuestions()) {
            Session::flash('danger', 'You can\'t answers more questions today!');
            return Redirect::back();
        }
        $this->validate($request, [
            'answer'      => 'required',
            'question_id' => 'required',
            'attempt_id'  => 'required',
            'test_id'     => 'required',
            'user_id'     => 'required',
        ]);

        if (Input::get('user_id') != Auth::id()) {
            return 'Error: you\'re trying to create an answer for another user';
        }

        $answer = new Answer(Input::all());

        $answer->save();

        if (is_null($answer->test_id)) {
            return Redirect::route('questionsView', [
                'question_id' => $answer->question_id,
            ]);
        } else {
            return Redirect::route('attemptsContinue', [
                'attempt_id' => $answer->attempt_id,
            ]);
        }
    }
}
