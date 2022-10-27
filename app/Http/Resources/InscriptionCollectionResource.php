<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InscriptionCollectionResource extends ResourceCollection
{

    public function toArray($request): array
    {
        return [
            'data' => $this->collection->transform(fn($inscription) => [
                'id' => $inscription->id,
                'eleve' => $this->eleve,
                'classe' => ClasseResource::make($this->classe),
                'annee' => $this->annee,
                'categorie' => $inscription->categorie,
                'montant' => $inscription->montant,
                'status' => $inscription->status,
                'code' => $inscription->code,
                'created_at' => $inscription->created_at,
                'updated_at' => $inscription->updated_at,
            ]),
        ];
    }
}
