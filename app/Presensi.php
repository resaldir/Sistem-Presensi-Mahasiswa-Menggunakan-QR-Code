<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensis';
    protected $primaryKey = 'presensiId';
    protected $fillable = [
        'presensiKlsId',
        'presensiKrsId',
        'presensiQrcodeKode',
        'presensiStatus',
        'long',
        'lang',
        'presensiDevId'
    ];


    public function krs(){
        return $this->belongsTo('App\Krs','presensiKrsId','krsId');
    }

    public function kelas(){
        return $this->belongsTo('App\Kelas','presensiKlsId','klsId');
    }

    public function qrcode(){
        return $this->hasOne('App\Qrcode','qrcodeKode','presensiQrcodeKode');
    }

    public function izins(){
        return $this->hasMany('App\Izin','izinPresensiId','presensiId');
    }
}
