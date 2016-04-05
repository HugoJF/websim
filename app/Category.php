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

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function getViewLink()
    {
        return route('categoriesView', ['category_id' => $this->id]);
    }

    public function getParentLink()
    {
        return route('categoriesView', ['category_id' => $this->id]);
    }
}
