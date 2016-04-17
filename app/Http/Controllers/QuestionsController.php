<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use App\Report;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Session;
use Setting;
use View;

class QuestionsController extends Controller
{
    public function listAllQuestions()
    {
        if (Setting::get('filter_answered_questions')) {
            $answeredQuestions = Auth::user()->answers()->select('question_id')->get()->pluck('question_id');
        } else {
            $answeredQuestions = [];
        }

        $questions = Question::with([
            'votes' => function ($query) {
                $query->where('user_id', Auth::id());
            },
            'votes.user',
            'user',
            'answers',
        ])->whereNotIn('id', $answeredQuestions)->paginate(10);

        return View::make('questions.list')->with(compact('questions'));
    }

    public function viewQuestion($id = -1)
    {
        $question = Question::with('user', 'votes', 'votes.user', 'comments', 'comments.user')->find($id);

        return View::make('questions.view')->with(compact('question'));
    }

    public function category($category_id = -1)
    {
        $categories = Category::find($category_id)->getDescendantsAndSelf()->pluck('id');
        $questions = Question::with('user')->whereIn('category_id', $categories)->paginate(10);

        return View::make('questions.list')->with(compact('questions'));
    }

    public function search()
    {
        if (Input::has('query')) {
            $questions = Question::where('question_title', 'LIKE', '%'.Input::get('query').'%')->paginate(10)->appends(Input::except('page'));
            $query = Input::get('query');

            return View::make('questions.list')->with(compact('questions', 'query'));
        } else {
            return View::make('questions.searchForm');
        }
    }

    public function showSubmitForm()
    {
        $categoriesORM = Category::all(['id', 'depth', 'name']);

        $categories = [];

        foreach ($categoriesORM as $category) {
            $categories[$category->id] = str_repeat('― ', $category->depth).$category->name;
        }

        return View::make('questions.submitForm')->with(compact('categories'));
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'question_title'          => 'required|min:5',
            'question_alternatives'   => 'required|array',
            'question_alternatives.*' => 'required',
            'correct_alternative'     => 'required|numeric',
            'category_id'             => 'required',
        ]);

        $question = new Question();

        $question->user()->associate(Auth::id());

        $question->category_id = Input::get('category_id');

        $question->question_title = Input::get('question_title');

        foreach (Input::get('question_alternatives') as $alternative) {
            $question->addAlternative($alternative);
        }

        $question->setCorrectAlternative(Input::get('correct_alternative'));

        $question->save();

        return Redirect::to($question->getViewURL());
    }

    public function showFlagForm($question_id)
    {
        $question = Question::find($question_id);

        return view('flagging.submitForm')->with(compact('question'));
    }

    public function flag(Request $request, $question_id)
    {
        $this->validate($request, [
            'reason'  => 'required',
            'details' => 'required',
        ]);

        $report = new Report(Input::all());

        $report->owner()->associate(Question::find($question_id));
        $report->user()->associate(Auth::user());

        $report->save();

        Session::flash('success', 'Report submitted sucessfully!');

        return Redirect::back();
    }

    public function showEditForm($question_id)
    {
        $categoriesORM = Category::all();

        $categories = [];

        foreach ($categoriesORM as $category) {
            $select[$category->id] = str_repeat('― ', $category->depth).$category->name;
        }

        $question = Question::find($question_id);

        return View::make('question.editForm')->with(compact('question', 'categories'));
    }

    public function edit(Request $request, $question_id)
    {
        $this->validate($request, [
            'question_title'          => 'required|min:5',
            'question_alternatives'   => 'required|array',
            'question_alternatives.*' => 'required',
            'correct_alternative'     => 'required|numeric',
            'category_id'             => 'required',
        ]);

        $question = Question::find($question_id);

        $question->fill(Input::all());

        $question->clearAlternatives();

        foreach (Input::get('question_alternatives') as $alternative) {
            $question->addAlternative($alternative);
        }

        $question->setCorrectAlternative(Input::get('correct_alternative'));

        $question->save();

        Session::flash('success', 'Question updated successfully');

        return Redirect::to($question->getViewURL());
    }

    public function myQuestions()
    {
        $questions = Auth::user()->questions()->paginate(10);

        return View::make('questions.list')->with(compact('questions'));
    }
}
