<?php

namespace App\Enums;

enum DepenseStatus: string
{
    case pending = 'pending';
    case approved_1 = 'approved_1';
    case rejected_1 = 'rejected_1';
    case approved_2 = 'approved_2';
    case rejected_2 = 'rejected_2';
    case canceled = 'canceled';
    case issued = 'issued';
    case done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::pending => 'En attente',
            self::approved_1 => 'Approuvé par le coordinateur',
            self::rejected_1 => 'Rejeté par le coordinateur',
            self::approved_2 => 'Approuvé par le promoteur',
            self::rejected_2 => 'Rejeté par le promoteur',
            self::canceled => 'Annulé',
            self::issued => 'Payé',
            self::done => 'Terminé',
            default => 'Inconnu',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::pending => 'bg-yellow-500',
            self::approved_1 => 'bg-green-500',
            self::rejected_1 => 'bg-red-500',
            self::approved_2 => 'bg-green-500',
            self::rejected_2 => 'bg-red-500',
            self::canceled => 'bg-red-500',
            self::issued => 'bg-green-500',
            self::done => 'bg-green-500',
            default => 'bg-gray-500',
        };
    }

    /**
     * Get the roles that can change the status.
     */
    public function roles(): ?array
    {
        return match ($this) {
            self::pending, self::rejected_1 => [UserRole::coordinateur, UserRole::admin],
            self::approved_1, self::rejected_2 => [UserRole::promoteur, UserRole::admin],
            default => null,
        };
    }


}
