<?php

namespace App\Enum;

enum AdmissionStatus: string
{
    case pending = 'pending';
    case approved = 'approved';
    case rejected = 'rejected';
    case canceled = 'canceled';

    // label() is a method that returns the label of the enum
    public function label(): string
    {
        return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvé',
            self::rejected => 'Rejeté',
            self::canceled => 'Annulé',
        };
    }
}
