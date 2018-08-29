<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Totalqrcode extends Model
{
    protected $table = 'totalqrcodes';
    protected $primaryKey = 'totKlsId';
    protected $fillable = [
        'totKlsId',
        'totCodeCreated',
    ];

    public function mtk(){
        return $this->belongsTo('App\Kelas','totKlsId','klsId');
    }
}
