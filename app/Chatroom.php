<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    //
    protected $fillable = ['name', 'description','lophoc_id'];
    public function class()
    {
        return $this->belongsTo('App\Lophoc','lophoc_id','id');
    }
}
