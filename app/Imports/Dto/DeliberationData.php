<?php

namespace App\Imports\Dto;

use App\Models\Deliberation;
use App\Models\Etudiant;

class DeliberationData
{
    public static function fromRow(
        array    $row,
        Etudiant $etudiant,
        string   $promotion_code,
        string   $annee,
        int      $deliberation_start,
    ): Deliberation
    {

        return Deliberation::updateOrCreate([
            'etudiant_id' => $etudiant->id,
            'promotion_code' => $promotion_code,
            'session' => $row[$deliberation_start + 6],
            'annee' => $annee,
        ], [
            'nbre_echec' => $row[$deliberation_start],
            'total_pondere' => $row[$deliberation_start + 1],
            'pourcentage' => $row[$deliberation_start + 2],
            'moyenne_ponderee' => $row[$deliberation_start + 3],
            'credits_valides' => $row[$deliberation_start + 4],
            'decision' => $row[$deliberation_start + 5],
        ]);

    }
}
