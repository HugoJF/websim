<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    private $jsonInformation = null;

    /**
     * Return tests related to this question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tests()
    {
        return $this->belongsToMany('App\Test');
    }

    /**
     * Return votes related to this question.
     *
     * @return mixed
     */
    public function votes()
    {
        return $this->hasMany('App\QuestionVote');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Return comments related to this question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function answers()
    {
        return $this->hasMany('App\Question');
    }

    public function pivot()
    {
        return $this->hasOne('App\QuestionTest');
    }

    /**
     * Calculates the score based on votes.
     *
     * @return mixed
     */
    public function getScore()
    {
        return $this->votes()->get()->reduce(function ($carry, $item) {
            if ($item->direction == 1) {
                return $carry + 1;
            } else {
                return $carry - 1;
            }
        });
    }

    public function getInformationAsJson()
    {
        if ($this->jsonInformation === null) {
            $this->jsonInformation = json_decode($this->information);
        }

        return $this->jsonInformation;
    }

    public function getPossibleAnswers()
    {
        return $this->getInformationAsJson()->possibleAnswers;
    }

    public function isCorrect($index)
    {
        return $index == $this->getInformationAsJson()->correctAnswer;
    }
}
