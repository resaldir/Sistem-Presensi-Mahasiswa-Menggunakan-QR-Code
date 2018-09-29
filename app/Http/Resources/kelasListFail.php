<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class kelasListFail extends JsonResource
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
          'error'=>true,
          'pesan'=>'Anda tidak terdaftar sebagai mahasiswa aktif'
        ];
    }
}
