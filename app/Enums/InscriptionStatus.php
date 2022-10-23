<?php

namespace App\Enums;

enum InscriptionStatus: string
{
    case pending = 'pending';
    case approved = 'approved';
    case rejected = 'rejected';
    case canceled = 'canceled';

    // label() is a method that returns the label of the enum
    public function label($sexe = Sexe::m): string
    {
        if ($sexe == Sexe::m) return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvé',
            self::rejected => 'Rejeté',
            self::canceled => 'Annulé',
        };
        else return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvée',
            self::rejected => 'Rejetée',
            self::canceled => 'Annulée',
        };
    }


    // label() is a method that returns the label of the enum
    public function pluralLabel($sexe = Sexe::m): string
    {
        if ($sexe == Sexe::m) return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvés',
            self::rejected => 'Rejetés',
            self::canceled => 'Annulés',
        };
        else return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvées',
            self::rejected => 'Rejetées',
            self::canceled => 'Annulées',
        };
    }

}
