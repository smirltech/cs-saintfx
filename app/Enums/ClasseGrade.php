<?php

namespace App\Enums;

enum ClasseGrade: string
{
    case g1 = '1ère';
    case g2 = '2ème';
    case g3 = '3ème';
    case g4 = '4ème';
    case g5 = '5ème';
    case g6 = '6ème';
    case g7 = '7ème';
    case g8 = '8ème';

    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::g1 => '1ère Année',
            self::g2 => '2ème Année',
            self::g3 => '3ème Année',
            self::g4 => '4ème Année',
            self::g5 => '5ème Année',
            self::g6 => '6ème Année',
            self::g7 => '7ème Année',
            self::g8 => '8ème Année',
        };
    }
}
