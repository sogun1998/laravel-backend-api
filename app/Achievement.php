<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    //
    protected $fillable = [
        'student_id', 'classSubject_id'
    ];
}
