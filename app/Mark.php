<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    //
    protected $fillable = [
        'achievement_id', 'semester'
    ];
    public function achievement()
    {
        return $this->belongsTo('App\Achievement');
    }
    public function markDetail()
    {
        return $this->hasMany('App\MarkDetail');
    }


}
