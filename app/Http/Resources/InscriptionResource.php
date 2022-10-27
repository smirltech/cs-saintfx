<?php

namespace App\Http\Resources;

use App\Models\Classe;
use Illuminate\Http\Resources\Json\JsonResource;

class InscriptionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'eleve_id' => $this->eleve_id,
            'classe_id' => $this->classe_id,
            'annee_id' => $this->annee_id,
            'categorie' => $this->categorie,
            'montant' => $this->montant,
            'status' => $this->status,
            'code' => $this->code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'eleve' => $this->eleve,
            'classe' => ClasseResource::make($this->classe),
            'annee' => $this->annee,
        ];
    }
}
