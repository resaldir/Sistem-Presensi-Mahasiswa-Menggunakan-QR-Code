<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';
    protected $primaryKey = 'mhsId';
    protected $fillable = [
        'mhsId',
        'mhsNama',
        'mhsProdiKode',
        'mhsAngkatan',
        'mhsKurId'
    ];

    public function kurikulum(){
        return $this->belongsTo('App\Kurikulum','mhsKurId','kurId');
    }

    public function prodi(){
        return $this->hasOne('App\Prodi','prodiKode','mhsProdiKode');
    }

    public function mhs_aktifs(){
        return $this->belongsTo('App\MhsAktif','mhsAktifMhsId','mhsId');
    }

    public function user(){
        return $this->hasOne('App\User','nip','mhsId');
    }
}
