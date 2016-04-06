<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Question;
use App\Vote;
use App\Test;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class VoteController extends Controller
{
    public function dooo()
    {
        $vote = new Vote();

        $vote->user()->associate(Auth::user());
        $vote->owner()->associate(Comment::find(1));

        $vote->direction = true;

        return $vote;
    }
    public function questionVote($id, Request $r)
    {
        return $this->handleVote(Question::find($id), $r);
    }

    public function testVote($id, Request $r)
    {
        return $this->handleVote(Test::find($id), $r);
    }

    public function commentVote($id, Request $r)
    {
        return $this->handleVote(Comment::find($id), $r);
    }

    private function handleVote($model, $r)
    {
        $this->validate($r, [
            'direction' => 'required',
        ]);

        $direction = Input::get('direction') == 'true' ? true : false;


        // Tries to find a vote for the same question
        $vote = $model->votes()->where([
            'user_id'     => Auth::user()->id,
        ])->get();

        // If there is no vote for this question, create one
        if ($vote->count() == 0) {
            $vote = new Vote();

            $vote->user()->associate(Auth::user());
            $vote->owner()->associate($model);

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
        return redirect()->route('questionsView', ['question_id' => $model->id]);
    }
}
