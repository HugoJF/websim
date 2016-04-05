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
        return $this->hasMany('App\Answers');
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

    /**
     * Check if user is Administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type == 'admin';
    }
}
