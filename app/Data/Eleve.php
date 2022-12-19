<?php

namespace App\Data;

use App\Enums\Sexe;
use App\Traits\SaloonSerializer;

class Eleve
{
    use SaloonSerializer;

    public function __construct(
        public int $id,
        public string $nom,
        public string $postnom,
        public string $prenom,
        public Sexe $sexe,
        public string $matricule,
    )
    {
    }

    public static function serialize(mixed $data): static
    {
        return new static(
            id: $data['id'],
            nom: $data['nom'],
            postnom: $data['postnom'],
            prenom: $data['prenom'],
            sexe: Sexe::tryFrom($data['sexe']),
            matricule: $data['matricule']??'',
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'postnom' => $this->postnom,
            'prenom' => $this->prenom,
            'sexe' => $this->sexe,
            'matricule' => $this->matricule,
        ];
    }

    public function getNomComplet(): string
    {
        return "{$this->nom} {$this->postnom} {$this->prenom}";
    }
}
