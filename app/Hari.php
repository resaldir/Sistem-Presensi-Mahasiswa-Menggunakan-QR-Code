<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    protected $table = 'haris';
    protected $primaryKey = 'hariId';
    protected $fillable = [
        'hariNama',
    ];

    public function jadwals(){
        return $this->belongsTo('App\Jadwal','jdwlHari','hariId');
    }
}
