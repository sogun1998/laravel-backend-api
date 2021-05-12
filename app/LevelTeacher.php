<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelTeacher extends Model
{
    protected $fillable = [
        'admin_id', 'level', 'subject'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }
    public function teachers()
    {
        return $this->hasMany('App\User','level_id','id');
    }
}
