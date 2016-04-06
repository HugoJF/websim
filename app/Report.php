<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = ['reason', 'details'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function owner()
    {
        return $this->morphTo();
    }
}
