<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Mahasiswa extends JsonResource
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
                'nim'=>$this->mhsId,
                'token'=>$this->user->remember_token,
                'nama'=>$this->mhsNama,
                'angkatan'=>$this->mhsAngkatan,
                'Prodi'=>$this->prodi->prodiNama
            ]
        ];
    }
}
