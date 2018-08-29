<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    protected $primaryKey = 'id';
    protected $fillable = ['nama'];


    public function prodis(){

        return $this->hasMany('App\Prodi','prodiKodeFakultas','id');
    }
}
