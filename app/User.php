<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function level()
    {
        return $this->belongsTo('App\LevelTeacher');
    }
    public function class()
    {
        return $this->hasOne('App\Lophoc','teacher_id','id');
    }
    public function OauthAcessToken()
    {
        return $this->hasMany('App\OauthAccessToken');
    }
    public function classsubject()
    {
        return $this->hasMany('App\ClassSubject','teacher_id','id');
    }


}
