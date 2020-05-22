<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User sender
 * @property User recipient
 * @property int sender_id
 * @property int recipient_id
 * @property string subject
 * @property string content
 * @property int priority
 * @property bool is_new
 * @method static Mail | Collection find(array|\Illuminate\Http\Request|string $request)
 */
class Mail extends Model
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
