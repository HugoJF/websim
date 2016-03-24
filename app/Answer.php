<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = ['answer', 'attempt_id', 'question_id', 'user_id', 'test_id'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function attempt()
    {
        return $this->belongsTo('App\TestAttempt');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function setAttemptIdAttribute($value){
        $this->attributes['attempt_id'] = $value == "null" ? null : $value;
    }

    public function setTestIdAttribute($value){
        $this->attributes['test_id'] = $value == "null" ? null : $value;
    }

    public function isCorrect()
    {
        return $this->question->isCorrect($this->answer);
    }
}
