<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'dosen' => $this->dosen,
            'status' => $this->status,
            'waktu_hadir' => $this->waktu_hadir,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
