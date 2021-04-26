<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $fillable = [
        'subjectname', 'grade', 'school'
    ];
    public function classsubject()
    {
        return $this->hasMany('App\ClassSubject');
    }

}
