<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KelasListSukses extends JsonResource
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
            'error'=>false,
            'pesan'=>'Fetching Success',
            'kelas'=>KelasList::collection($this->krs)
        ];
    }
}
