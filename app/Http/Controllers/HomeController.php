<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use App\TestAttempt;
use App\User;
use Auth;
use View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testAttempts = Auth::user()->testAttempts()->unfinished()->limit(2)->get();
        $userCount = User::count();
        $testCount = Test::count();
        $questionCount = Question::count();
        $testAttemptCount = TestAttempt::count();

        return View::make('home')->with(compact('testAttempts', 'userCount', 'testCount', 'questionCount', 'testAttemptCount'));
    }
}
