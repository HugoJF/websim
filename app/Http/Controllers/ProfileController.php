<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Test;
use Auth;

class ProfileController extends Controller
{
    public function tests()
    {
        return Test::where('user_id', Auth::user()->id)->get();
    }

    public function questions()
    {
        return Question::where('user_id', Auth::user()->id)->get();
    }
}
