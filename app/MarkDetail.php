<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkDetail extends Model
{
    //
    protected $fillable = [
        'mark_id', 'comment', 'status', 'test_id','updated_at','mark'
    ];

    public function markid()
    {
        return $this->belongsTo('App\Mark','mark_id','id');
    }
    public function test()
    {
        return $this->belongsTo('App\Test');
    }
    public function hictory()
    {
        return $this->hasMany('App\Hictory','markDetail_id','id');
    }
}
