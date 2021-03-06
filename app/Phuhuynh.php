<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Phuhuynh extends Authenticatable
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
    public function student()
    {
        return $this->belongsTo('App\Student');
    }
}
