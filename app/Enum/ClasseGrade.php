<?php

namespace App\Enum;

enum ClasseGrade: string
{
    case g1 = '1e';
    case g2 = '2e';
    case g3 = '3e';
    case g4 = '4e';
    case g5 = '5e';
    case g6 = '6e';
    case g7 = '7e';
    case g8 = '8e';

    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::g1 => '1e Année',
            self::g2 => '2e Année',
            self::g3 => '3e Année',
            self::g4 => '4e Année',
            self::g5 => '5e Année',
            self::g6 => '6e Année',
            self::g7 => '7e Année',
            self::g8 => '8e Année',

        };
    }
}
