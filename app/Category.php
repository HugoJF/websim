<?php

namespace App;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;

class Category extends Node
{
    protected $table = 'categories';

    protected $guarded = array('id', 'parent_id', 'lidx', 'ridx', 'nesting');

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
