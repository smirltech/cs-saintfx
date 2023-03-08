<?php

namespace App\Imports\Dto;

use App\Models\Cotation;
use App\Models\Cours;
use App\Models\Etudiant;

class CotationData
{
    const COTATION_START = 3;
    const MOYENNE = 10;


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
            self::fromArray(
                etudiant: $etudiant,
                cours: $c,
                cote: $cotes[$key],
                promotion_code: $promotion_code,
                annee: $annee
            );
        }

    }

    public static function fromArray(Etudiant $etudiant, Cours $cours, string $cote, string $promotion_code, string $annee): Cotation
    {
        $cotation = Cotation::updateOrCreate([
            'etudiant_id' => $etudiant->id,
            'cours_id' => $cours->id,
            'promotion_code' => $promotion_code,
            'annee' => $annee,
        ], [
            'cote' => $cote,
        ]);

        // on enregistre les complements en cas d'echec
        if (intval($cote) < self::MOYENNE) {
            ComplementData::createComplement(
                etudiant: $etudiant,
                cours: $cours,
                cote: $cote,
                promotion_code: $promotion_code,
                annee: $annee);
        }

        return $cotation;

    }

}
