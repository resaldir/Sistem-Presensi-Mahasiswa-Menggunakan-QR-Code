<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nip', 'email', 'password','user_level','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function dosen(){
        return $this->belongsTo('App\Dosen','dsnNip','nip');
    }

    public function pegawai(){
        return $this->belongsTo('App\Pegawai','pegId','nip');
    }

    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa','mhsId','nip');
    }
}
