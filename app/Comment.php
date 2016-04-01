<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Database table name.
     *
     * @var string
     */
    protected $table = 'comments';

    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Return votes related to this comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany('App\CommentVotes');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /********************
     * CUSTOM FUNCTIONS *
     ********************/

    /**
     * Calculates de score based on votes related to this question.
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
}
