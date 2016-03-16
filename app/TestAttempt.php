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

    public function getResultURL()
    {
        return url('attempts/result/'.$this->id);
    }

    public function getAnsweredQuestionsAmount()
    {
        return $this->answers->count();
    }

    public function getUnansweredQuestionsAmount()
    {
        return $this->test->getQuestionAmount() - $this->getAnsweredQuestions();
    }

    public function getCorrectAnswersAmount()
    {
        $correctAnswers = 0;

        foreach($this->answers as $answer) {
            if($answer->isCorrect()) $correctAnswers++;
        }

        return $correctAnswers;
    }

    public function getIncorrectAnswersAmount()
    {
        $incorrectAnswers = 0;

        foreach ($this->answers as $answer) {
            if(!$answer->isCorrect()) $incorrectAnswers++;
        }

        return $incorrectAnswers;
    }
}
