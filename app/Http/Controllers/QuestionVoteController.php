<?php

namespace App\Http\Controllers;

use App\QuestionVote;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class QuestionVoteController extends Controller
{
    public function vote(Request $request)
    {
        $this->validate($request, [
            'question_id' => 'required',
            'direction'   => 'required',
        ]);

        $questionId = Input::get('question_id');
        $direction = Input::get('direction') == 'true' ? true : false;

        // Tries to find a vote for the same question
        $vote = QuestionVote::where([
            'question_id' => $questionId,
            'user_id'     => Auth::user()->id,
        ]);

        // If there is no vote for this question, create one
        if ($vote->count() == 0) {
            $vote = new QuestionVote();

            $vote->user_id = Auth::user()->id;
            $vote->question_id = $questionId;
        } else {
            $vote = $vote->first();
        }

        // If the user is trying to send the same vote, delete the vote

        if ($vote->direction !== null && $vote->direction == $direction) {
            $vote->delete();
        } else {
            // Change de direction of the vote
            $vote->direction = $direction;

            // Persist the vote
            $vote->save();
        }

        // Redirect to page
        // TODO Custom redirect
        return redirect()->route('questionsView', ['question_id' => $questionId]);
    }
}
