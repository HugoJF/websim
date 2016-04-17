<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use Auth;
use View;
use Setting;
use Session;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class TestController extends Controller
{
    public function index($id = -1)
    {
        $test = Test::with('user', 'questions')->find($id);

        if ($test->unlisted) {
            return 'Unlisted test, you should access it via the share link';
        }

        return View::make('tests.view')->with(compact('test'));
    }

    public function stub($stub)
    {
        $test = Test::with('user', 'questions')->where('stub', $stub)->first();

        return View::make('tests.view')->with(compact('test'));
    }

    public function listTests()
    {
        if(Setting::get('filter_answered_tests')) {
            $answeredTests = Auth::user()->testAttempts()->finished()->select('test_id')->get()->pluck('test_id');
        } else {
            $answeredTests = [];
        }

        $tests = Test::listed()->whereNotIn('id', $answeredTests)->with('questions', 'questions.user', 'user')->paginate(10);

        return View::make('tests.list')->with(compact('tests'));
    }

    public function myTests()
    {
        $tests = Auth::user()->tests()->paginate(10);

        return View::make('tests.list')->with(compact('tests'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'test_name'   => 'required',
        ]);

        \Debugbar::info(Input::all());

        $test = new Test();

        $test->name = Input::get('test_name');

        $test->user()->associate(Auth::user());

        $test->save();

        return Redirect::route('testView', ['test_id' => $test->id]);
    }

    public function showCreateForm()
    {
        return View::make('tests.submitForm');
    }

    public function showAddQuestionForm()
    {
        $tests = Auth::user()->tests()->get();

        return View::make('questions.addToTestForm')->with(compact('tests'));
    }

    public function addQuestion($questionId, Request $request)
    {
        $this->validate($request, [
            'test_id' => 'required',
        ]);

        $question = Question::find($questionId);

        $test = Test::find(Input::get('test_id'));

        if(!is_null($test->questions()->find($questionId))) {
           Session::flash('danger', 'You can\' add duplicate questions in a test');

            return Redirect::route('testView', ['test_id' => $test->id]);
        }

        $test->questions()->save($question);

        return Redirect::route('testView', ['test_id' => $test->id]);
    }
}
