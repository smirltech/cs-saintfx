<?php

namespace App\Enum;

enum PromotionGrade: string
{
    case prepa = 'PREPA';
    case bac1 = 'BAC1';
    case bac2 = 'BAC2';
    case bac3 = 'BAC3';
    case master1 = 'MSC1';
    case master2 = 'MSC2';

    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::prepa => 'Préparatoire',
            self::bac1 => 'Licence 1',
            self::bac2 => 'Licence 2',
            self::bac3 => 'Licence 3',
            self::master1 => 'Master 1',
            self::master2 => 'Master 2',

        };
    }
}
