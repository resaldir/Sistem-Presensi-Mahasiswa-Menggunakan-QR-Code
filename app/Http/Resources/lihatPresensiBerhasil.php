<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class lihatPresensiBerhasil extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $totalPresensi = $this->count();
        $totalHadir = $this->where('presensiStatus', 1)->count();
        return [
            'error'=>false,
            'pesan'=>'Fetching Berhasil',
            'total'=> $totalPresensi,
            'hadir'=>$totalHadir
        ];
    }
}
