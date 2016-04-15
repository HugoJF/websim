<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'schools';

    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    public function students()
    {
        return $this->hasMany('App\User');
    }
}
