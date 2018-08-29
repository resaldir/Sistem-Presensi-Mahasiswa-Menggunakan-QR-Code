<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosens';
    protected $primaryKey = 'dsnNip';
    protected $fillable = [
        'dsnNip',
        'dsnNidn',
        'dsnNama',
        'dsnProdiKode',
        'dsnFoto'
    ];

    public function prodi(){
        return $this->belongsTo('prodis','prodiKode','dsnProdiKode');
    }

    public function user(){
        return $this->hasOne('users','nip','dsnNip');
    }

    public function kelas(){
        return $this->belongsTo('App\Kelas','klsDsnNip','dsnNip');
    }
}
