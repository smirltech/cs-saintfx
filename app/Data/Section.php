<?php

namespace App\Data;

use App\Traits\SaloonSerializer;
use Illuminate\Support\Collection;

class Section
{
    use SaloonSerializer;

    public function __construct(
        public int         $id,
        public string      $nom,
        public string      $code,
        public ?Collection $options,
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
            options: ($data['options'] ?? null) ? self::serializeOptions($data['options']) : null,
            classes: ($data['classes'] ?? null) ? self::serializeClasses($data['classes']) : null,
        );
    }

    private static function serializeOptions(mixed $options)
    {
        return $options ? (new Collection($options))->map(fn($option) => Option::serialize($option)) : null;
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
            'options' => $this->options?->map(fn($option) => $option->toArray()),
            'classes' => $this->classes?->map(fn($classe) => $classe->toArray()),
        ];
    }

}
