<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTest extends Model
{
    protected $table = 'question_test';

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
