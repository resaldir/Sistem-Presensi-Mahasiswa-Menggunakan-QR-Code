<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Presensi extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'pertemuan'=>$this->qrcode->qrcodePertemuan,
            'status'=>$this->presensiStatus,
        ];
    }
}
