<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KelasList extends JsonResource
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
            'krsId' => $this->krsId,
            'klsId' => $this->krsKlsId,
            'mtkId' => $this->kelas->klsMtkId,
            'mtkNama' => $this->kelas->mtks->mtkNama,
            'kelas' => $this->kelas->klsNama,
            'sks' => $this->kelas->mtks->mtkTotalSks,
            'semester' => $this->kelas->mtks->mtkSemester,
            'Dosen' => $this->kelas->dosens->dsnNama,
        ];
    }
}
