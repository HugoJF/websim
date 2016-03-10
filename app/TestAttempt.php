<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestAttempt extends Model
{
    protected $table = 'tests_attempts';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer', 'attempt_id');
    }


    public function getResultURL() {
        return url('attempts/result/' . $this->id);
    }
}
