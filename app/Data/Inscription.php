<?php

namespace App\Data;

use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Traits\SaloonSerializer;
use DateTime;

class Inscription
{
    use  SaloonSerializer;

    public function __construct(
        public int                  $id,
        public string               $code,
        public ?Eleve               $eleve,
        public ?Annee               $annee,
        public ?Classe              $classe,
        public InscriptionCategorie $categorie,
        public InscriptionStatus    $status,
        public DateTime             $createdAt,
    )
    {
    }

    static function serialize(mixed $data): Inscription
    {

        return new static(
            id: $data['id'],
            code: $data['code'],
            eleve: ($data['eleve'] ?? null) ? Eleve::serialize($data['eleve']) : null,
            annee: ($data['annee'] ?? null) ? Annee::serialize($data['annee']) : null,
            classe: ($data['classe'] ?? null) ? Classe::serialize($data['classe']) : null,
            categorie: InscriptionCategorie::tryFrom($data['categorie']),
            status: InscriptionStatus::tryFrom($data['status']),
            createdAt: new DateTime($data['created_at'])
        );

    }

    function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'eleve' => $this->eleve?->toArray(),
            'annee' => $this->annee,
            'classe' => $this->classe?->toArray(),
            'categorie' => $this->categorie->value,
            'status' => $this->status->value,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];

    }

}
