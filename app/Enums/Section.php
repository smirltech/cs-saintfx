<?php

namespace App\Enums;

enum Section: string
{
    case MATERNELLE = 'MAT';
    case PRIMAIRE = 'P';
    case ETUDE_BASE = 'EB';
    case SECONDAIRE = 'S';

    public function label(): string
    {
        return match ($this) {
            self::MATERNELLE => 'Maternelle',
            self::PRIMAIRE => 'Primaire',
            self::ETUDE_BASE => 'Etude de base',
            self::SECONDAIRE => 'Secondaire',
        };
    }

    public function level(): int
    {
        return match ($this) {
            self::MATERNELLE => 1,
            self::PRIMAIRE => 2,
            self::ETUDE_BASE => 3,
            self::SECONDAIRE => 4,
        };
    }
}
