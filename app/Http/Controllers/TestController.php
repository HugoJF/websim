<?php

namespace App\Http\Controllers;

use App\Test;

class TestController extends Controller
{
    public function index($id = -1)
    {
        $test = Test::with('user', 'questions')->find($id);

        if ($test->unlisted) {
            return 'Unlisted test, you should access it via the share link';
        }

        return view('test')->with([
            'test' => $test,
        ]);
    }

    public function stub($stub)
    {
        $test = Test::with('user', 'questions')->where('stub', $stub)->first();

        return view('test')->with([
            'test' => $test,
        ]);
    }

    public function listTests()
    {

        //return view('test_list')->with([
        return view('test_list')->with([
            'tests' => Test::where('unlisted', false)->with('questions', 'questions.user', 'user')->paginate(10),
        ]);
    }
}
