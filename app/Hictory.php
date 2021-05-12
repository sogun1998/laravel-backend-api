<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hictory extends Model
{
    //
    protected $fillable = [
        'markDetail_id', 'text', 'status','isActive'
    ];
    public function markDetail()
    {
        return $this->belongsTo('App\MarkDetail','markDetail_id','id');
    }
}
