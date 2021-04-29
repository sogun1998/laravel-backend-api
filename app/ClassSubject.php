<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    //
    protected $fillable = [
        'lophoc_id', 'subject_id', 'teacher_id'
    ];
    public function teacher()
    {
        return $this->belongsTo('App\User','teacher_id','id');
    }
    public function lophoc()
    {
        return $this->belongsTo('App\Lophoc');
    }
    public function subject()
    {
        return $this->belongsTo('App\Subject');

    }
    public function achievements()
    {
        return $this->hasMany('App\Achievement');
    }


}
