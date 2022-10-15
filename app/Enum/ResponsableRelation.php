<?php

namespace App\Enum;

enum ResponsableRelation: string
{
    case oncle = 'oncle';
    case tante = 'tante';
    case pere = 'pere';
    case mere = 'mere';
    case frere = 'frere';
    case soeur = 'soeur';
    case autre = 'autre';

    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::oncle => 'Oncle',
            self::tante => 'Tante',
            self::pere => 'Père',
            self::mere => 'Mère',
            self::frere => 'Frère',
            self::soeur => 'Soeur',
            self::autre => 'Autre',

        };
    }
}
