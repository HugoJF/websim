<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * Return the question related to this comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question() {
        return $this->belongsTo('App\Question');
    }

    /**
     * Return votes related to this comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes() {
        return $this->hasMany('App\CommentVotes');
    }

    /********************
     * CUSTOM FUNCTIONS *
     ********************/

    /**
     * Calculates de score based on votes related to this question
     *
     * @return mixed
     */
    public function getScore() {
        return $this->votes()->get()->reduce(function($carry, $item) {
            if($item->direction == 1) {
                return $carry + 1;
            } else {
                return $carry - 1;
            }
        });
    }
}
