<?php

namespace App\Imports\Dto;

use App\Enums\Sexe;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use Carbon\Carbon;
use Exception;

class InscriptionData
{

    /**
     * @throws Exception
     */
    public static function fromRow(array $data, string $annee_id, string $classe_id): Inscription
    {
        $section_id = Classe::find($classe_id)->section_id;
        $eleve = Eleve::updateOrCreate(
            [
                'nom' => $data[1]
            ],
            [
                'section_id' => $section_id,
                'nom' => $data[1],
                'sexe' => self::getSexe($data[2]),
                'lieu_naissance' => self::getLieuNaissance($data[3]),
                'date_naissance' => self::getDateNaissance($data[3]),
                'pere' => [
                    'nom' => $data[4],
                    'profession' => $data[6],
                ],
                'mere' => [
                    'nom' => $data[5],
                    'profession' => $data[7],
                ],
                'adresse' => $data[8],
                'telephone' => $data[9],
                'email' => $data[10],
            ]);


        return Inscription::firstOrCreate(
            [
                'eleve_id' => $eleve->id,
                'annee_id' => $annee_id,
            ],
            [
                'eleve_id' => $eleve->id,
                'annee_id' => $annee_id,
                'classe_id' => $classe_id,
            ]);

    }

    // is valid student id

    private static function getSexe(string $value): ?Sexe
    {
        return Sexe::tryFrom(strtolower($value));
    }

    private static function getLieuNaissance(string $value): string
    {
        $lieu = explode(',', $value);
        return trim($lieu[0]);
    }

    private static function getDateNaissance(mixed $value): string
    {
        $date = explode(',', $value);
        if (count($date) < 2) {
            return '';
        }

        $date = explode('/', $date[1]);


        $c = Carbon::create(trim($date[2]), trim($date[1]), trim($date[0]));

        return $c->format('Y-m-d');
    }

}
