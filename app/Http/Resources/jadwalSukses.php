<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class jadwalSukses extends JsonResource
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
            'jadwal' => Jadwal::collection(\App\Jadwal::all()->where('jdwlKlsId', $this->klsId))

        ];
    }
}
