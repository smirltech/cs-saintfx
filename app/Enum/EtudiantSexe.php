<?php

namespace App\Enum;

enum EtudiantSexe: string
{
    case f = 'F';
    case m = 'M';

    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::f => 'Femme',
            self::m => 'Homme',
        };
    }
}
