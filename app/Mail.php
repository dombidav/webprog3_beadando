<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function safeID(Mail $mail, bool $prefix = true) : string
    {
        $i = Mail::innerID($mail);
        return ($prefix ? 'm/' : '') . $mail->sender->username . '/' . $i;
    }

    public static function from(string $str){
        preg_match('/([a-z])\/([a-z0-9._-]+)\/([0-9]+)(?:\/([0-9]+))*/', $str, $matches, PREG_UNMATCHED_AS_NULL);
        if(sizeof($matches) == null)
            return null;
        $user_id = User::name($matches[2])->id;
        return Mail::where('sender_id', '=', $user_id)->get()->skip($matches[3])->first();
    }

    public static function innerID(Mail $mail)
    {
        $all_task = DB::table('mails')->where('sender_id', '=', $mail->sender->id)->get();
        $i = 0;
        while ($all_task->skip($i)->first()->id != $mail->id){
            $i++;
        }
        return $i;
    }
}
