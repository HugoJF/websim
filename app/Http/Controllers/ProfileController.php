<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Answer;
use App\Test;
use App\Question;
use Auth;

class ProfileController extends Controller
{
    public function answers()
    {
        return Answer::where('user_id', Auth::user()->id)->get()->groupBy('attempt_id');
    }

    public function tests()
    {
        return Test::where('user_id', Auth::user()->id)->get();
    }

    public function questions()
    {
        return Question::where('user_id', Auth::user()->id)->get();
    }
}
