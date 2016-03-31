<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use App\QuestionVote;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function listAllQuestions()
    {
        return view('question_list')->with([
            'questions' => Question::with(['user', 'votes' => function ($query) { $query->where('user_id', Auth::user()->id); }, 'answers'])->paginate(10),
        ]);
    }

    public function viewQuestion($id = -1)
    {
        $vote = QuestionVote::where([
            'question_id' => $id,
            'user_id'     => Auth::user()->id,
        ]);

        if ($vote->count() == 0) {
            $vote = null;
        } else {
            $vote = (bool) $vote->first()->direction;
        }

        return view('question')->with([
            'question' => Question::find($id),
            'vote'     => $vote,
        ]);
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
        return view('submit_question');
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'question_title'          => 'required|min:5',
            'question_alternatives'   => 'required|array',
            'question_alternatives.*' => 'required',
            'correct_alternative'     => 'required|numeric',
        ]);

        $question = new Question();

        $question->user()->associate(Auth::user()->id);

        $question->question_title = Input::get('question_title');

        foreach (Input::get('question_alternatives') as $alternative) {
            $question->addAlternative($alternative);
        }

        $question->setCorrectAlternative(Input::get('correct_alternative'));

        $question->save();

        return redirect($question->getViewLink());
    }
}
