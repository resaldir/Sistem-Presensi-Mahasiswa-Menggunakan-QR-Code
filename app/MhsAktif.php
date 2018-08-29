<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MhsAktif extends Model
{
    protected $table = 'mhs_aktifs';
    protected $primaryKey = 'mhsAktifId';
    protected $fillable = [
        'mhsAktifMhsId',
        'mhsAktifSemId',
    ];

    public function semester(){
        return $this->belongsTo('App\Semester','mhsAktifSemId','semId');
    }

    public function mahasiswa(){
        return $this->hasOne('App\Mahasiswa','mhsId','mhsAktifMhsId');
    }

    public function krs(){
        return $this->hasMany('App\Krs','krsMhsAktifId','mhsAktifId');
    }


}
