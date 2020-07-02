<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'alamat', 'telp', 'photo','username', 'email', 'password', 'affiliate_id', 'referred_by', 'jabatan',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages(){
        return $this->hasMany('App\Message', 'user_id', 'id');
    }

    public function assets(){
        return $this->hasMany('App\Asset', 'pembuat_id', 'id');
    }

    public function blogs(){
        return $this->hasMany('App\Blog', 'pembuat_id', 'id');
    }

    public function documents(){
        return $this->hasMany('App\Document', 'pembuat_id', 'id');
    }
}
