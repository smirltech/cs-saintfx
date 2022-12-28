<?php

namespace App\Enums;

enum PresenceStatus: string
{
    case present = 'present';
    case absent = 'absent';
    case malade = 'malade';
    case autre = 'autre';

    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::present => 'Présent',
            self::absent => 'Absent',
            self::malade => 'Malade',
            self::autre => 'Autre',
        };
    }
}
