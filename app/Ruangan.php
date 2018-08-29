<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangans';
    protected $primaryKey = 'ruanganId';
    protected $fillable = [
        'ruanganKode',
        'ruanganProdiKode',
        'ruanganKapasitas'
    ];

    public function prodi(){
        return $this->belongsTo('App\Prodi','ruanganProdiKode','prodiKode');
    }

    public function jadwals(){
        return $this->belongsTo('App\Jadwal','jdwlRuanganId','ruanganId');
    }


}
