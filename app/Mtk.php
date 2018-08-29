<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mtk extends Model
{
    protected $table = 'mtks';
    protected $primaryKey = 'mtkId';
    protected $fillable = [
        'mtkId',
        'mtkNama',
        'mtkKurId',
        'mtkSemester',
        'mtkTotalSks',
        'mtkTeoriSks',
        'mtkPraktekSks'
    ];

    public function kurikulums(){
        return $this->hasOne('App\Kurikulum','kurId','mtkKurId');
    }

    public function kelas(){
        return $this->belongsTo('App\Kelas','klsMtkId','mtkId');
    }

    public function krs(){
        return $this->hasMany('App\Krs','krsMtkId','mtkId');
    }
}
