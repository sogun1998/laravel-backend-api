<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conduct extends Model
{
    //
    protected $fillable = [
        'mark', 'status', 'date', 'achievement_id'
    ];
    public function achievement()
    {
        return $this->belongsTo('App\Achievement');
    }
}
