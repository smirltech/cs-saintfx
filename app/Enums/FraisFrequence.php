<?php

namespace App\Enums;

enum FraisFrequence: string
{
    case mensuel = 'mensuel';
    case trimestriel = 'trimestriel';
    case semestriel = 'semestriel';
    case annuel = 'annuel';

    // label() is a method that returns the label of the enum
    public function label(): string
    {
        return match ($this) {
            self::mensuel => 'Mensuel',
            self::trimestriel => 'Trimestriel',
            self::semestriel => 'Semestriel',
            self::annuel => 'Annuel',
        };
    }

    // children() is a method that returns the children of the enum
    public function children(): array
    {
        return match ($this) {
            self::mensuel => array_column(Mois::cases(), 'value'),
            self::trimestriel => ['trimestre_1', 'trimestre_2', 'trimestre_3', 'trimestre_4'],
            self::semestriel => ['semestre_1', 'semestre_2'],
            self::annuel => ['annee'],
        };
    }

}
