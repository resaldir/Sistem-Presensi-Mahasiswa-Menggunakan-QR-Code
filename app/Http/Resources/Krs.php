<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Krs extends JsonResource
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
            'pesan'=>'Request Berhasil',
            'user'=>[
            'nim'=>$this->mahasiswa->mhsId,
            'token'=>$this->mahasiswa->user->remember_token,
            'nama'=>$this->mahasiswa->mhsNama,
            'angkatan'=>$this->mahasiswa->mhsAngkatan,
            'Prodi'=>$this->mahasiswa->prodi->prodiNama,
            ],'kelas'=>Kelas::collection($this->krs),
        ];
    }

}
