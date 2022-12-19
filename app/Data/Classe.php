<?php

namespace App\Data;

use App\Traits\SaloonSerializer;
use Illuminate\Support\Collection;

class Classe
{
    use SaloonSerializer;

    public function __construct(
        public int         $id,
        public string      $grade,
        public string      $code,
        public Filierable  $filierable,
        public string      $filierableType,
        public ?Collection $inscriptions,
    )
    {
    }

    public static function serialize(mixed $data): static
    {
        return new static(
            id: $data['id'],
            grade: $data['grade'],
            code: $data['code'],
            filierable: Filierable::serialize($data['filierable']),
            filierableType: $data['filierable_type'],
            inscriptions: ($data['inscriptions'] ?? null) ? self::serializeInscriptions($data['inscriptions']) : null,
        );
    }

    private static function serializeInscriptions(mixed $inscriptions)
    {
        return $inscriptions ? (new Collection($inscriptions))->map(fn($inscription) => Inscription::serialize($inscription)) : null;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'grade' => $this->grade,
            'code' => $this->code,
            'filierable' => $this->filierable->toArray(),
            'filierableType' => $this->filierableType,
            'inscriptions' => $this->inscriptions?->map(fn($inscription) => $inscription->toArray()),
        ];
    }

}
