<?php

namespace App\Enums;

enum InscriptionCategorie: string
{
    case normal = "normal";
    case enseignant = 'enseignant';

    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::normal => 'Normal',
            self::enseignant => 'Enfant d\'enseignant',
        };
    }
}
