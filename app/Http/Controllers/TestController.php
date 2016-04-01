<?php

namespace App\Http\Controllers;

use App\Question;
use App\Test;
use Auth;
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

    public function myTests()
    {
        return view('test_list')->with([
            'tests' => Auth::user()->tests()->paginate(10)
        ]);
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

        return redirect('/test/'.$test->id);
    }

    public function showCreateForm()
    {
        return view('add_test');
    }

    public function showAddQuestionForm()
    {
        return view('add_question_to_test')->with([
            'tests' => Auth::user()->tests()->get(),
        ]);
    }

    public function addQuestion($questionId, Request $request)
    {
        $this->validate($request, [
            'test_id' => 'required',
        ]);

        $question = Question::find($questionId);

        $test = Test::find(Input::get('test_id'));

        $test->questions()->save($question);

        return redirect('test/'.$test->id);
    }
}
