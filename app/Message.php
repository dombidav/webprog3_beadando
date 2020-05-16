<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function sender(){
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function recipient(){
        return $this->belongsTo('App\User', 'recipient_id');
    }
}
