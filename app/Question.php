<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = ['question_title', 'information', 'category_id'];

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
        return $this->morphMany('App\Vote', 'owner');
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
        return $this->morphMany('App\Comment', 'owner');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function reports()
    {
        return $this->morphMany('App\Report', 'owner');
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
        return $this->votes->reduce(function ($carry, $item) {
            if ($item->direction == 1) {
                return $carry + 1;
            } else {
                return $carry - 1;
            }
        });
    }

    public function isUserOwner($user)
    {
        return $this->user->id == $user->id;
    }

    public function getViewURL()
    {
        return route('questionsView', ['question_id' => $this->id]);
    }

    public function getTotalAnswers()
    {
        $totalAnswers = 0;
        foreach ($this->answers as $answer) {
            $totalAnswers++;
        }

        return $totalAnswers;
    }

    public function getTotalCorrectAnswers()
    {
        $totalCorrectAnswers = 0;
        foreach ($this->answers as $answer) {
            if ($this->isCorrect($answer->answer)) {
                $totalCorrectAnswers++;
            }
        }

        return $totalCorrectAnswers;
    }

    public function getCurrentUserVote()
    {
        return $this->getUserVote(Auth::user()->id);
    }

    public function getUserVote($id)
    {
        return $this->votes->where('user_id', $id)->first();
    }

    public function getCorrectAnswersPercentage()
    {
        $totalCorrectAnswers = $this->getTotalCorrectAnswers();
        $totalAnswers = $this->getTotalAnswers();
        if ($totalAnswers != 0) {
            return round($this->getTotalCorrectAnswers() / $this->getTotalAnswers() * 100);
        } else {
            return 0;
        }
    }

    public function getTotalIncorrectAnswers()
    {
        $totalIncorrectAnswers = 0;
        foreach ($this->answers as $answer) {
            if ($this->isCorrect($answer->answer)) {
                $totalIncorrectAnswers++;
            }
        }

        return $totalIncorrectAnswers;
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

    public function clearAlternatives()
    {
        $this->getInformationAsJson();

        $this->jsonInformation->possibleAnswers = [];
    }

    public function addAlternative($alternative)
    {
        $this->getInformationAsJson();

        $this->jsonInformation->possibleAnswers[] = $alternative;

        $this->information = json_encode($this->jsonInformation);
    }

    public function setCorrectAlternative($correctAlternative)
    {
        $this->getInformationAsJson();

        $this->jsonInformation->correctAnswer = $correctAlternative;

        $this->information = json_encode($this->jsonInformation);
    }
}
