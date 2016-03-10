<?php

namespace App\Http\Controllers;

use App\Test;

class TestController extends Controller
{
    public function index($id = -1)
    {
        $test = Test::with('user', 'questions')->find($id);

        return view('test')->with([
            'test' => $test,
        ]);
    }

    public function listTests()
    {

        //return view('test_list')->with([
        return view('test_list')->with([
            'tests' => Test::with('questions', 'questions.user', 'user')->paginate(10),
        ]);
    }
}
