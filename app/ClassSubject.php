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
        return $this->belongsTo('App\User');
    }
    public function lophoc()
    {
        return $this->belongsTo('App\Lophoc');
    }
    public function subject()
    {
        return $this->belongsTo('App\Subject');

    }

}
