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
    public function classsubject()
    {
        return $this->belongsTo('App\ClassSubject','classSubject_id','id');
    }
    public function mark()
    {
        return $this->hasOne('App\Mark');
    }
    public function conduct()
    {
        return $this->hasMany('App\Conduct');
    }
}
