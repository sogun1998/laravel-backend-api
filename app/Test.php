<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //
    protected $fillable = [
        'classSubject_id', 'testname', 'percentage'
    ];
    public function classSubject()
    {
        return $this->belongsTo('App\ClassSubject','classSubject_id','id');
    }

    public function markDetail()
    {
        return $this->hasMany('App\MarkDetail');
    }
}
