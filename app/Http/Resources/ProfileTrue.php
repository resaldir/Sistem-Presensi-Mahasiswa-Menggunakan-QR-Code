<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileTrue extends JsonResource
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
            'nim'=>$this->mhsId,
            'nama'=>$this->mhsNama,
            'angkatan'=>$this->mhsAngkatan,
            'prodi'=>$this->prodi->prodiNama
        ];
    }
}
