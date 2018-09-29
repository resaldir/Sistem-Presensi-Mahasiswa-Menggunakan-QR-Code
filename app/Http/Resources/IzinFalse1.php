<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IzinFalse1 extends JsonResource
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

        ];
    }

    public function with($request)
    {
        return [
            'error'=>true,
            'pesan'=>'Gagal dalam mengupdate status'
        ];
    }
}
