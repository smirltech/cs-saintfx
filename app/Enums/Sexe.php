<?php

namespace App\Enums;

enum Sexe: string
{
    case f = 'F';
    case m = 'M';

    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::f => 'Feminin',
            self::m => 'Masculin',
        };
    }
}
