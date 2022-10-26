<?php

namespace App\Enums;

enum InscriptionCategorie: string
{
    case normal = "normal";
    case enfant_enseignant = 'enfant_enseignant';

    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::normal => 'Normal',
            self::enfant_enseignant => 'Enfant d\'enseignant',
        };
    }
}
