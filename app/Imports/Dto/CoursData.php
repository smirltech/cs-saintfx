<?php

namespace App\Imports\Dto;

use App\Models\Cours;

class CoursData
{
    public const COURS_DELIMITER = "NOMBRE D'ECHEC";
    const COURS_MAX = 20;

    /**
     */
    public static function createFromArray(array $data, string $promotion_code, ?string $cm = null, ?string $td = null, ?string $tp = null, ?string $tpe = null,): Cours
    {
        $data = (object)(array_change_key_case($data));
        return
            self::createCours(
                nom: $data->nom,
                credits: $data->credits,
                promotion_code: $promotion_code,
                cm: $data->cm,
                td: $data->td,
                tp: $data->tp,
                tpe: $data->tpe,
            );

    }

    public static function createCours(string $nom, string $credits, string $promotion_code, ?string $cm = null, ?string $td = null, ?string $tp = null, ?string $tpe = null,): Cours
    {
        return Cours::updateOrCreate([
            'nom' => $nom,
            'promotion_code' => $promotion_code,
        ], [
            'credits' => intval($credits),
            'cm' => intval($cm),
            'td' => intval($td),
            'tp' => intval($tp),
            'tpe' => intval($tpe),
        ]);


    }

}
