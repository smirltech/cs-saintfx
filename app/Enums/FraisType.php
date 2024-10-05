<?php

namespace App\Enums;

use Exception;

enum FraisType: string
{
    case INSCRIPTION = 'INSCRIPTION';
    case MINERVAL = 'MINERVAL';
    case KIT = 'KIT';
    case ETAT = 'ETAT';
    case CONNEXE = 'CONNEXE';

    //folder() is a method that returns the folder name
    public function folder(): string
    {
        return match ($this) {
            self::INSCRIPTION => 'inscriptions',
            self::KIT => 'kits',
            self::ETAT => 'etat',
            self::CONNEXE => 'connexe',
            self::MINERVAL => 'minerval',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::INSCRIPTION => 'Frais d\'inscription',
            self::KIT => 'Frais de kit',
            self::ETAT => 'Frais de l\'état',
            self::CONNEXE => 'Frais connexe',
            self::MINERVAL => 'Frais de minerval',
        };
    }

    public function subtypes(): ?array
    {
        return match ($this) {
            self::MINERVAL => MinervalType::cases(),
            self::ETAT => EtatType::cases(),
            self::KIT, self::INSCRIPTION, self::CONNEXE => null,
        };
    }


}
