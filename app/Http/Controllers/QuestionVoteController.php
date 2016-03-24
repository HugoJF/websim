<?php

namespace App\Http\Controllers;

use App\CommentVotes;
use App\QuestionVote;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class QuestionVoteController extends Controller
{
    public function voteUp($questionId)
    {
        return $this->vote($questionId, true);
    }

    public function voteDown($questionId)
    {
        return $this->vote($questionId, false);
    }

    private function vote($questionId, $voteVal)
    {
        // Tries to find a vote for the same question
        $vote = QuestionVote::where([
            'question_id' => $questionId,
            'user_id'     => Auth::user()->id,
        ]);

        // If there is no vote for this question, create one
        if($vote->count() == 0) {
            $vote = new QuestionVote();

            $vote->user_id = Auth::user()->id;
            $vote->question_id = $questionId;
        } else {
            $vote = $vote->first();
        }

        // If the user is trying to send the same vote, delete the vote
        if($vote->direction == $voteVal) {
            $vote->delete();
        } else {
            // Change de direction of the vote
            $vote->direction = $voteVal;

            // Persist the vote
            $vote->save();
        }

        // Redirect to page
        // TODO Custom redirect
        return redirect('questions/'.$questionId);
    }
}
