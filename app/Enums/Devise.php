<?php

namespace App\Enums;

enum Devise: string
{
    case USD = 'USD';

    public function symbol(): string
    {
        return match ($this) {
            self::USD => '$',
        };
    }

    // label is used for displaying the enum value in the UI
    public function label(): string
    {
        return match ($this) {
            self::USD => 'Dollar Américain',
        };
    }


}
