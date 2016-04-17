<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Question;
use App\Test;
use App\Vote;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class VoteController extends Controller
{
    public function questionVote($id, Request $request)
    {
        return $this->handleVote(Question::find($id), $request);
    }

    public function testVote($id, Request $request)
    {
        return $this->handleVote(Test::find($id), $request);
    }

    public function commentVote($id, Request $request)
    {
        return $this->handleVote(Comment::find($id), $request);
    }

    private function handleVote($model, $request)
    {
        $this->validate($request, [
            'direction' => 'required',
        ]);

        $direction = Input::get('direction') == 'true' ? true : false;

        // Tries to find a vote for the same question
        $vote = $model->votes()->where([
            'user_id' => Auth::id(),
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

        if (!is_null($vote->direction) && $vote->direction == $direction) {
            $vote->delete();
        } else {
            // Change de direction of the vote
            $vote->direction = $direction;

            // Persist the vote
            $vote->save();
        }

        // Redirect to page
        // TODO Custom redirect
        return Redirect::route('questionsView', ['question_id' => $model->id]);
    }
}
