<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'user_id', 'chatroom',
    ];

    /**
     * Get the user that the message belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
