<?php

namespace App\Data;

use App\Traits\SaloonSerializer;
use Illuminate\Support\Collection;

class Option
{
    use SaloonSerializer;

    public function __construct(
        public int         $id,
        public string      $nom,
        public string      $code,
        public string      $section_id,
        public ?Collection $filieres,
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
            section_id: $data['section_id'],
            filieres: ($data['filieres'] ?? null) ? self::serializeFilieres($data['filieres']) : null,
            classes: ($data['classes'] ?? null) ? self::serializeClasses($data['classes']) : null,
        );
    }

    private static function serializeFilieres(mixed $filieres)
    {
        return $filieres ? (new Collection($filieres))->map(fn($filiere) => Filiere::serialize($filiere)) : null;
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
            'section_id' => $this->section_id,
            'filieres' => $this->filieres?->map(fn($filiere) => $filiere->toArray()),
            'classes' => $this->classes?->map(fn($classe) => $classe->toArray()),
        ];
    }

}
