<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Jadwal extends JsonResource
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
            'hari'=> $this->haris->hariNama,
            'mulai'=> $this->jdwlSesiMulai,
            'selesai'=> $this->jdwlSesiSelesai,
//            'mtkId'=> $this->kelas->klsMtkId,
//            'mtkNama'=> $this->kelas->mtks->mtkNama,
//            'kelas'=> $this->kelas->klsNama,
//            'mtkSks'=> $this->kelas->mtks->mtkTotalSks,
//            'mtkSem'=> $this->kelas->mtks->mtkSemester,
//            'dosen'=> $this->kelas->dosens->dsnNama,
            'ruangan'=> $this->ruangans->ruanganKode,
        ];
    }
}
