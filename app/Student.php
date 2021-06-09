<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    //
    use HasApiTokens,Notifiable;
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
        'password',
    ];
    public function OauthAcessToken()
    {
        return $this->hasMany('App\OauthAccessToken','user_id','id');
    }
    public function class()
    {
        return $this->belongsTo('App\Lophoc','lophoc_id','id');
    }
    public function achievement()
    {
        return $this->hasMany('App\Achievement');
    }
    public function parent()
    {
        return $this->hasOne('App\Phuhuynh');
    }
    public function conductSummary()
    {
        return $this->hasMany('App\ConductSummary','student_id','id');
    }
    public function scopeFullname($query, $request)
    {
        if ($request->has('fullname')) {
            $query->where('fullname', 'LIKE', '%' . $request->fullname . '%');
        }
        return $query;
    }
    public function scopeName($query, $request)
    {
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        return $query;
    }



}
