<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $table = 'kurikulums';
    protected $primaryKey = 'kurId';
    protected $fillable = [
        'kurId',
        'kurProdiKode',
        'kurTahun',
        'kurNama'
    ];

    public function prodis(){
        return $this->belongsTo('App\Prodi','ProdiKode','kurProdiKode');
    }

    public function mtks(){
        return $this->belongsTo('App\Mtk','mtkKurId','kurId');
    }

    public function mahasiswas(){
        return $this->hasMany('App\Mahasiswa','mhsKurId','kurId');
    }
}
