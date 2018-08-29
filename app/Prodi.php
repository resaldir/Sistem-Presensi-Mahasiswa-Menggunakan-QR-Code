<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodis';
    protected $primaryKey = 'prodiKode';
    protected $fillable = [
        'prodiKode',
        'prodiNama',
        'prodiKodeFakultas',
        'prodiJenjang'
    ];

    public function fakultas(){
        return $this->belongsTo('App\Fakultas','id','prodiKodeFakultas');
    }

    public function dosens(){
        return $this->hasMany('App\Dosen','dsnProdiKode','prodiKode');
    }

    public function pegawais(){
        return $this->hasMany('App\Pegawai','pegProdiKode','prodiKode');
    }

    public function kurikulum(){
        return $this->hasMany('App\Kurikulum','kurProdiKode','prodiKode');
    }

    public function semester(){
        return $this->hasMany('App\Semester','semId','prodiKode');
    }

    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa','mhsProdiKode','prodiKode');
    }

    public function ruangan(){
        return $this->hasMany('App\Ruangan','ruanganProdiKode','prodiKode');
    }
}
