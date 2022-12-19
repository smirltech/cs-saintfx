<?php

namespace App\Data;

use App\Traits\SaloonSerializer;

class Filierable
{
    use SaloonSerializer;

    //$data['filierable_type']::find($data['filierable_id'])
    public function __construct(
        public int $id,
        public string $nom,
        public string $code,
    )
    {
    }

    public static function serialize(mixed $data): static
    {
        return new static(
            id: $data['id'],
            nom: $data['nom'],
            code: $data['code'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'code' => $this->code,
        ];
    }

}
