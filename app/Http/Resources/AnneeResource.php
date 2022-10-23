<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnneeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'libelle' => $this->nom,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'encours' => $this->encours,
        ];
    }
}
