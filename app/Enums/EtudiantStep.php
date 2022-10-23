<?php

namespace App\Enums;

enum EtudiantStep: string
{
    case one = '1';
    case two = '2';
    case three = '3';
    case four = '4';
    case five = '5';
    case complete = 'complete';

    public function label(): string
    {
        return match ($this) {
            self::one => 'Informations personnelles',
            self::two => 'Informations sur les responsables',
            self::three => 'Pièces d\'identité',
            self::four => 'Etudes secondaires',
            self::five => 'Choix du programme',
            self::complete => 'Complété',
        };
    }
}
