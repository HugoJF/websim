<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';

    /**
     * Returns questions related to this test.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }

    public function attempts()
    {
        return $this->hasMany('App\TestAttempt');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function pivot()
    {
        return $this->hasOne('App\QuestionTest');
    }

    public function getQuestionAmount()
    {
        return $this->questions->count();
    }
}
