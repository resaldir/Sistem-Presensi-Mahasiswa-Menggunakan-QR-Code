<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    protected $table = 'qrcodes';
    protected $primaryKey = 'qrcodeId';
    protected $fillable = [
        'qrcodeKlsId',
        'qrcodeWaktuAkhir',
        'qrcodePertemuan',
        'qrcodeKode'
    ];
    protected $dates = [
        'qrcodeWaktuAkhir',
        'created_at'
    ];

    public function mtk(){
        return $this->belongsTo('App\Kelas','qrcodeKlsId','klsId');
    }

    public function presensis(){
        return $this->belongsTo('app\Presensi','presensiQrcodeKode','qrcodeKode');
    }

}
