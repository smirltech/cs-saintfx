<?php

namespace App\Enums;

enum InscriptionCategorie: int
{
    case normal = 1;
    case enseignant = 2;
    case enfant_5 = 3;
    case enfant_6 = 4;

    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::normal => 'Normal',
            self::enseignant => 'Enfant du personnel',
            self::enfant_5 => '5e enfant',
            self::enfant_6 => '6e enfant',
        };
    }
}
