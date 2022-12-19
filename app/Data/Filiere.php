<?php

namespace App\Data;

use App\Traits\SaloonSerializer;
use Illuminate\Support\Collection;

class Filiere
{
    use SaloonSerializer;

    public function __construct(
        public int         $id,
        public string      $nom,
        public string      $code,
        public string      $option_id,
        public ?Collection $classes,
    )
    {
    }

    public static function serialize(mixed $data): static
    {
        return new static(
            id: $data['id'],
            nom: $data['nom'],
            code: $data['code'],
            option_id: $data['option_id'],
            classes: ($data['classes'] ?? null) ? self::serializeClasses($data['classes']) : null,
        );
    }

    private static function serializeClasses(mixed $classes)
    {
        return $classes ? (new Collection($classes))->map(fn($classes) => Classe::serialize($classes)) : null;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'code' => $this->code,
            'option_id' => $this->option_id,
            'classes' => $this->classes?->map(fn($classe) => $classe->toArray()),
        ];
    }

}
