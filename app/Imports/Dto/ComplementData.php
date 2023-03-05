<?php

namespace App\Imports\Dto;

use App\Models\Complement;
use App\Models\Cours;
use App\Models\Etudiant;

class ComplementData
{
    const COTATION_START = 3;


    public static function fromRow(
        array    $cotes,
        array    $cours,
        array    $credits,
        Etudiant $etudiant,
        string   $promotion_code,
        string   $annee
    ): void
    {
        foreach ($cours as $key => $value) {

            if (trim($value) === CoursData::COURS_DELIMITER) {
                break;
            }

            if ($key < self::COTATION_START or empty($value)) { # On saute les 3 premiers et les vides
                continue;
            }

            $c = CoursData::createCours($value, $credits[$key], $promotion_code);
            self::createComplement(
                etudiant: $etudiant,
                cours: $c,
                cote: $cotes[$key],
                promotion_code: $promotion_code,
                annee: $annee
            );


        }


    }

    public static function createComplement(Etudiant $etudiant, Cours $cours, string $cote, string $promotion_code, string $annee): Complement
    {
        return Complement::updateOrCreate([
            'etudiant_id' => $etudiant->id,
            'cours_id' => $cours->id,
            'promotion_code' => $promotion_code,
            'annee' => $annee,
        ], [
            'cote' => $cote,
        ]);

    }

}
