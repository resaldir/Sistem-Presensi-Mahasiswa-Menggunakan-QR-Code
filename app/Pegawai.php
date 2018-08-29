<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawais';
    protected $primaryKey = 'pegId';
    protected $fillable = [
        'pegId',
        'pegNama',
        'pegProdiKode',
        'pegFoto'
    ];

    public function prodi(){
        return $this->belongsTo('prodis','prodiKode','pegProdiKode');
    }

    public function user(){
        return $this->hasOne('users','nip','pegId');
    }

}
