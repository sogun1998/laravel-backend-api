<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelTeacher extends Model
{
    protected $fillable = [
        'admin_id', 'level', 'subject','grade'
    ];

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }
    public function teacher()
    {
        return $this->hasMany('App\User');
    }
}
