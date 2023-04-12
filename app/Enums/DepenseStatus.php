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
            self::pending => 'info',
            self::approved_1, self::approved_2 => 'success',
            self::rejected_1, self::rejected_2 => 'danger',
            self::canceled => 'warning',
            self::issued => 'primary',
            self::done => 'secondary',
            default => 'default',
        };
    }

    /**
     * Get the roles that can change the status.
     */
    public function roles(): ?array
    {
        return match ($this) {
            self::pending, self::rejected_1 => [UserRole::coordinateur->value, UserRole::admin->value],
            self::approved_1, self::rejected_2 => [UserRole::promoteur->value, UserRole::admin->value],
            default => null,
        };
    }


}
