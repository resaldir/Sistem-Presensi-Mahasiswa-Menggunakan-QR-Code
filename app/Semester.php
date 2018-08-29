<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semesters';
    protected $primaryKey = 'semId';
    protected $fillable = [
        'semId',
        'semTglMulai',
        'semTglSelesai',
        'semTahun',
        'semProdiKode',
        'semTipe',
        'semIsAktif'
    ];

    public function prodi(){
        return $this->belongsTo('App\Prodi','prodiKode','semId');
    }

    public function mhs_aktifs(){
        return $this->hasMany('App\MhsAktif','mhsAktifSemId','semId');
    }
    public function kelas(){
        return $this->hasMany('App\Kelas','klsSemId','semId');
    }

    public function jadwals(){
        return $this->hasMany('App\Jadwal','jdwlSemId','semId');
    }

}
