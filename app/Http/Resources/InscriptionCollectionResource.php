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
                'eleve' => $inscription->eleve,
                'classe' => ClasseResource::make($inscription->classe),
                'annee' => $inscription->annee,
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
