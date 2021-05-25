<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConductSummary extends Model
{
    //
    protected $fillable = [
        'mark', 'comment', 'student_id','semester'
    ];
    public function student()
    {
        return $this->belongsTo('App\Student');
    }
}
