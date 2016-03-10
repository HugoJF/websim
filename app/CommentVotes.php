<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentVotes extends Model
{
    protected $table = 'comment_votes';

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}
