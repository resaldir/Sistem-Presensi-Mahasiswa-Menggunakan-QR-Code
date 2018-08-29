<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    protected $table = 'krs';
    protected $primaryKey = 'krsId';
    protected $fillable = [
        'krsKlsId',
        'krsMhsAktifId'
    ];

    public function mhs_aktif(){
        return $this->hasOne('App\MhsAktif','mhsAktifId','krsMhsAktifId');
    }

    public function kelas(){
        return $this->hasOne('App\Kelas','klsId','krsKlsId');
    }

    public function presensis(){
        return $this->hasMany('App\Presensi','presensiKrsId','krsId');
    }


}
