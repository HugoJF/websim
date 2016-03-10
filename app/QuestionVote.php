<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionVote extends Model
{
    protected $table = 'question_votes';

    public function question() {
        return $this->belongsTo('App\Question');
    }
}
