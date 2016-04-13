<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use App\TestAttempt;
use App\User;
use Auth;

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
        return view('home')->with([
            'test_attempts'    => Auth::user()->testAttempts()->unfinished()->limit(2)->get(),
            'userCount'        => User::count(),
            'testCount'        => Test::count(),
            'questionCount'    => Question::count(),
            'testAttemptCount' => TestAttempt::count(),
        ]);
    }

    public function something()
    {
        $test = TestRepository::get(1);

        //return '-> ' . $test->questions()->first()->getScore();
        return $test->questions()->first()->comments()->first()->toJson();

        //return 'Yey';
    }
}
