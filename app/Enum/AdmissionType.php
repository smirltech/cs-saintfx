<?php

namespace App\Enum;

enum AdmissionType: string
{
    case inscription = 'inscription';
    case preinscription = 'preinscription';
    case reorientation = 'reorientation';
    case redoublement = 'redoublement';
    case transfert = 'transfert';
    case autre = 'autre';

    // label() is a method that returns the label of the enum
    public function label(): string
    {
        return match ($this) {
            self::inscription => 'Inscription',
            self::preinscription => 'Préinscription',
            self::reorientation => 'Réorientation',
            self::redoublement => 'Redoublement',
            self::transfert => 'Transfert',
            self::autre => 'Autre',
        };
    }

}
