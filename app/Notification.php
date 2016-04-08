<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = ['notification', 'read'];

    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    public function read()
    {
        $this->read = true;
        $this->read_at = new Carbon();
    }

    public function unread()
    {
        $this->read = false;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
