<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Contracts\TestRepository;
use App\Http\Requests;

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
        return view('home');
    }

    public function something() {
        $test = TestRepository::get(1);

        //return '-> ' . $test->questions()->first()->getScore();
        return $test->questions()->first()->comments()->first()->toJson();

        //return 'Yey';
    }
}
