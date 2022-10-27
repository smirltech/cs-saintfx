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
                'eleve_id' => $inscription->eleve_id,
                'classe_id' => $inscription->classe_id,
                'annee_id' => $inscription->annee_id,
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
