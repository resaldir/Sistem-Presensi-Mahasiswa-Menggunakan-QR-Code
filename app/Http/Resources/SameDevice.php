<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SameDevice extends JsonResource
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
            'pesan'=>'Perangkat sudah pernah digunakan'
        ];
    }
}
