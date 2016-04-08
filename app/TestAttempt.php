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
        return route('attemptsResult', ['attempt_id' => $this->id]);
    }

    public function getViewURL()
    {
        return route('attemptsContinue', ['attempt_id' => $this->id]);
    }

    public function scopeUnfinished($query)
    {
        return $query->where('finished', 0);
    }

    public function scopeFinished($query)
    {
        return $query->where('finished', 1);
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

        foreach ($this->answers as $answer) {
            if ($answer->isCorrect()) {
                $correctAnswers++;
            }
        }

        return $correctAnswers;
    }

    public function getIncorrectAnswersAmount()
    {
        $incorrectAnswers = 0;

        foreach ($this->answers as $answer) {
            if (!$answer->isCorrect()) {
                $incorrectAnswers++;
            }
        }

        return $incorrectAnswers;
    }
}
