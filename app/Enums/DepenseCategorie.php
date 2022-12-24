<?php

namespace App\Enums;

enum DepenseCategorie: string
{
    case equipement = 'equipement';
    case consommable = 'consommable';
    case frais_direct = 'frais_direct';
    case frais_administratif = 'frais_administratif';
    case autre = 'autre';

    /**
     * @return string
     */
    public function label(): string
    {
        // match the enum value with the label, using match expression
        return match ($this) {
            DepenseCategorie::equipement=>"Équipement",
            DepenseCategorie::consommable=>"Consommable",
            DepenseCategorie::frais_direct=>"Frais Direct",
            DepenseCategorie::frais_administratif=>"Frais Administratif",
            DepenseCategorie::autre=>"Autre",
        };
    }
}
