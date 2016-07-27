<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'x2_user';
    protected $primaryKey = 'userid';
    
	public $timestamps = false;
	
    protected $timestamp = ['userregtime', 'userlogtime'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'useremail', 'userpassword', 'userregtime', 'userlogtime', 'userregip', 'api_token', 'nickname','qq','weixin','address','mailname','mailphone'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'userpassword', 'userregtime', 'userlogtime', 'userregip', 'api_token',
        'manager_apps', 'photo', 'usertruename', 'normal_favor', 'teacher_subjects',
        'userphone'
    ];
}
