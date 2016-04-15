<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'type',
    ];

    public function testAttempts()
    {
        return $this->hasMany('App\TestAttempt');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function tests()
    {
        return $this->hasMany('App\Test');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function school()
    {
        return $this->belongsTo('App\School');
    }

    public function ownedSchool()
    {
        return $this->hasOne('App\School');
    }

    /**
     * Check if user is Administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function canAnswerQuestions()
    {
        return $this->answers()->today()->count() <= 5 || $this->school;
    }

    public function remainingQuestions()
    {
        if(\Auth::user()->school) {
            return 1000;
        } else {
            return 5 - $this->answers()->today()->count();
        }
    }
}
