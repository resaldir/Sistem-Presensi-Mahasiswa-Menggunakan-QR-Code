<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
//    protected $primaryKey = 'klsId';
    protected $fillable = [
        'klsId',
        'klsDsnNip',
        'klsMtkId',
        'klsSemId',
        'klsNama',
        'klsJumlahPer'
    ];

    public function mtks(){
        return $this->hasOne('App\Mtk','mtkId','klsMtkId');
    }

    public function dosens(){
        return $this->hasOne('App\Dosen','dsnNip','klsDsnNip');
    }

    public function semesters(){
        return $this->belongsTo('App\Semester','semId','klsSemId');
    }

    public function krs(){
        return $this->belongsTo('App\Krs','krsKlsId','klsId');
    }

    public function jadwals(){
        return $this->belongsTo('App\Jadwal','jdwlKlsId','klsId');
    }

    public function qrcode(){
        return $this->hasMany('App\Qrcode','qrcodeKlsId','klsId');
    }

    public function totQrcode(){
        return $this->hasMany('App\Totalqrcode','totKlsId','klsId');
    }

    public function presensis(){
        return $this->hasMany('App\Presensi','presensiKlsId','klsId');
    }

}
