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

    public function color(): string
    {
        return match ($this) {
            self::present => 'success',
            self::absent => 'danger',
            self::malade => 'warning',
            self::autre => 'info',
        };
    }

    public function color2(): string
    {
        return match ($this) {
            self::present => 'green',
            self::absent => 'red',
            self::malade => 'orange',
            self::autre => 'teal',
        };
    }
}
