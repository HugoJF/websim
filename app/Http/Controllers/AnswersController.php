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
            'answers' => Answer::where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function submit(Request $request)
    {
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

        return redirect('/attempts/continue/'.Input::get('attempt_id', '-1'));
    }
}
