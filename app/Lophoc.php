<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lophoc extends Model
{
    //
    protected $fillable = [
        'classname', 'grade', 'school', 'teacher_id'
    ];
    public function teacher()
    {
        return $this->belongsTo('App\User');
    }
    public function students()
    {
        return $this->hasMany('App\Student');
    }
    public function classsubject()
    {
        return $this->hasMany('App\ClassSubject');
    }


}
