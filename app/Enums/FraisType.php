<?php

namespace App\Enums;

enum FraisType: string
{
    case inscription = 'inscription';
    case frais_scolarite = 'frais_scolarite';
    case frais_divers = 'frais_divers';
    case frais_direct = 'frais_direct';
    case frais_administratif = 'frais_administratif';

    //folder() is a method that returns the folder name
    public function folder(): string
    {
        return match ($this) {
            self::inscription => 'inscriptions',
            self::frais_scolarite => 'frais_scolarite',
            self::frais_divers => 'frais_divers',
            self::frais_direct => 'frais_direct',
            self::frais_administratif => 'frais_administratif',
        };
    }

    //label() is a method that returns the label of the enum
    public function label(): string
    {
        return match ($this) {
            self::inscription => 'Inscription',
            self::frais_scolarite => 'Frais de scolarite',
            self::frais_divers => 'Frais divers',
            self::frais_direct => 'Frais direct',
            self::frais_administratif => 'Frais administratif',
        };
    }


}
