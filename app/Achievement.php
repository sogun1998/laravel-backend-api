<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    //
    protected $fillable = [
        'student_id', 'classSubject_id'
    ];
    public function student()
    {
        return $this->belongsTo('App\Student');
    }
    public function classSubject()
    {
        return $this->belongsTo('App\ClassSubject');
    }

}
