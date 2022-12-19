<?php

namespace App\Data;

use App\Traits\SaloonSerializer;

class Annee
{
    use SaloonSerializer;

    public function __construct(
        public int  $id,
        public string  $nom,
        public ?string $debut,
        public ?string $fin,
        public string  $encours,
    )
    {
    }

    public static function serialize(mixed $data): static
    {
        return new static(
            id: $data['id'],
            nom: $data['nom'],
            debut: $data['date_debut']??null,
            fin: $data['date_fin']??null,
            encours: $data['encours'],
        );
    }

    function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'debut' => $this->debut,
            'fin' => $this->fin,
            'encours' => $this->encours,
        ];
    }
}
