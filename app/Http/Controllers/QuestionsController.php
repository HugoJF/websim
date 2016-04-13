<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use App\Report;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use App\Answer;

class QuestionsController extends Controller
{
    public function listAllQuestions()
    {
        if(\Setting::get('filter_answered_questions')) {
            $answeredQuestions = Auth::user()->answers()->select('question_id')->get()->pluck('question_id');
        } else
        {
            $answeredQuestions = [];
        }

        return view('question_list')->with([
            'questions' => Question::with(['user', 'votes' => function ($query) { $query->where('user_id', Auth::user()->id); }, 'votes.user', 'answers'])->whereNotIn('id', $answeredQuestions)->paginate(10),
        ]);
    }

    public function viewQuestion($id = -1)
    {
        $question = Question::with('user', 'votes', 'votes.user', 'comments', 'comments.user')->find($id);

        return view('question')->with([
            'question' => $question,
        ]);
    }

    public function viewQuestionComments($question_id = -1)
    {
        return Question::find($question_id)->comments()->with('votes', 'user')->get();
        //return Question::find(1)->votes()->get();
    }

    public function category($category_id = -1)
    {
        $categories = Category::find($category_id)->getDescendantsAndSelf()->pluck('id');

        //return Question::with('user')->whereIn('category_id', $categories)->paginate(10);
        return view('question_list')->with([
            'questions' => Question::with('user')->whereIn('category_id', $categories)->paginate(10),
        ]);
    }

    public function search()
    {
        if (Input::has('query')) {
            return view('question_list')->with([
                'questions' => Question::where('question_title', 'LIKE', '%'.Input::get('query').'%')->paginate(10)->appends(Input::except('page')),
                'query'     => Input::get('query'),

            ]);
        } else {
            return view('question_search_form');
        }
    }

    public function showSubmitForm()
    {
        $categories = Category::all();

        $select = [];

        foreach ($categories as $category) {
            $select[$category->id] = str_repeat('― ', $category->depth).$category->name;
        }

        return view('submit_question')->with([
            'categories' => $select,
        ]);
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

        $question->user()->associate(Auth::user()->id);

        $question->category_id = Input::get('category_id');

        $question->question_title = Input::get('question_title');

        foreach (Input::get('question_alternatives') as $alternative) {
            $question->addAlternative($alternative);
        }

        $question->setCorrectAlternative(Input::get('correct_alternative'));

        $question->save();

        return redirect($question->getViewURL());
    }

    public function showFlagForm($question_id)
    {
        return view('flag_form')->with([
            'question' => Question::find($question_id),
        ]);
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

        $request->session()->flash('success', 'Report submitted sucessfully!');

        return redirect()->back();
    }

    public function showEditForm($question_id)
    {
        $categories = Category::all();

        $select = [];

        foreach ($categories as $category) {
            $select[$category->id] = str_repeat('― ', $category->depth).$category->name;
        }

        return view('edit_question')->with([
            'question'   => Question::find($question_id),
            'categories' => $select,
        ]);
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

        return redirect($question->getViewURL());
    }

    public function myQuestions()
    {
        return view('question_list')->with([
            'questions' => Auth::user()->questions()->paginate(10),
        ]);
    }
}
