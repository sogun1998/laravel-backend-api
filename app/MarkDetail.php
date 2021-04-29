<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkDetail extends Model
{
    //
    protected $fillable = [
        'mark_id', 'comment', 'status', 'test_name'
    ];

    public function markDetail()
    {
        return $this->belongsTo('App\Mark');
    }
}
