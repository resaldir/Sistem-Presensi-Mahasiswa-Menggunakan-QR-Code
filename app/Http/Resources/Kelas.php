<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Kelas extends JsonResource
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
            'Presensi' => Presensi::collection(\App\Presensi::all()->where('presensiKrsId', $this->krsId)->where('presensiKlsId', $this->kelas->klsId)),
            'jadwal' => Jadwal::collection(\App\Jadwal::all()->where('jdwlKlsId', $this->krsKlsId))
        ];
    }
}
