<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals';
    protected $primaryKey = 'jdwlId';
    protected $fillable = [
        'jdwlKlsId',
        'jdwlHari',
        'jdwlSesiMulai',
        'jdwlSesiSelesai',
        'jdwlRuanganId',
        'jdwlSemId'
    ];


    public function ruangans(){
        return $this->hasOne('App\Ruangan','ruanganId','jdwlRuanganId');
    }

    public function kelas(){
        return $this->hasOne('App\Kelas','klsId','jdwlKlsId');
    }

    public function haris(){
        return $this->hasOne('App\Hari','hariId','jdwlHari');
    }

    public function semesters(){
        return $this->belongsTo('App\Semester','semId','jdwlSemId');
    }
}

