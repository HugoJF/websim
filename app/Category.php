<?php

namespace App;

use Baum\Node;

class Category extends Node
{
    protected $table = 'categories';

    protected $guarded = ['id', 'parent_id', 'lidx', 'ridx', 'nesting'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
