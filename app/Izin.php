<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $table = 'izins';
    protected $primaryKey = 'izinId';
    protected $fillable = [
        'izinPresensiId',
        'izinFileName'
    ];

    public function presensi(){
        return $this->belongsTo('App\Presensi','izinPresensiId','presensiId');
    }
}
