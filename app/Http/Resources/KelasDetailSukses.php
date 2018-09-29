<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KelasDetailSukses extends JsonResource
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
            'mtkId' => $this->klsMtkId,
            'mtkNama' => $this->mtks->mtkNama,
            'kelas' => $this->klsNama,
            'sks' => $this->mtks->mtkTotalSks,
            'semester' => $this->mtks->mtkSemester,
            'Dosen' => $this->dosens->dsnNama,
        ];
    }
}
