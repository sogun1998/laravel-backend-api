<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = ['room', 'sender', 'content', 'receiver'];
    public function sender() {
//        return $this->belongsTo(User::class);
        if($this->sender_role == 0) {
            return $this->belongsTo('App\User', 'sender', 'id');
        }
        else{
            return $this->belongsTo('App\Phuhuynh', 'sender', 'id');
        }
    }
    public function receiver() {
//        return $this->belongsTo(User::class);
        if($this->receiver_role == 0) {
            return $this->belongsTo('App\User', 'receiver', 'id');
        }
        else{
            return $this->belongsTo('App\Phuhuynh', 'receiver', 'id');
        }
    }
    public function room () {
        return $this->belongsTo(Chatroom::class, 'room');
    }
}
