<?php

namespace App\Imports\Dto;

use App\Enums\InscriptionStatus;
use App\Enums\ResponsableRelation;
use App\Enums\Sexe;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use Carbon\Carbon;
use Exception;

class InscriptionData
{

    /**
     * @throws Exception
     */
    public static function fromRow(array $data, string $annee_id, string $classe_id): bool
    {
        $section_id = Classe::find($classe_id)->section_id;


        $responsable = self::createResponsable(data: $data);
        $eleve = self::createEleve(data: $data, section_id: $section_id);
        self::createInscription(eleve_id: $eleve->id, annee_id: $annee_id, classe_id: $classe_id);
        self::createResponsableEleve(eleve_id: $eleve->id, responsable_id: $responsable?->id, relation: $data[4] ? ResponsableRelation::pere : ResponsableRelation::mere);

        return true;

    }

    // is valid student id

    private static function createResponsable(array $data): ?Responsable
    {
        if ($data[4]) {
            return Responsable::updateOrCreate(
                [
                    'nom' => $data[4],
                ],
                [
                    'nom' => $data[4],
                    'profession' => $data[6],
                    'adresse' => $data[8],
                    'sexe' => Sexe::m,
                    'telephone' => $data[9],
                    'email' => $data[10],
                ]);
        }

        if ($data[5]) {
            return Responsable::updateOrCreate(
                [
                    'nom' => $data[5],
                ],
                [
                    'nom' => $data[5],
                    'profession' => $data[7],
                    'adresse' => $data[8],
                    'sexe' => Sexe::f,
                    'telephone' => $data[9],
                    'email' => $data[10],
                ]);
        }

        return null;
    }

    private static function createEleve(array $data, string $section_id): Eleve
    {
        return Eleve::updateOrCreate(
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

    }

    private static function getSexe(string $value): ?Sexe
    {
        return Sexe::tryFrom($value);
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

    private static function createInscription(string $eleve_id, string $annee_id, string $classe_id): Inscription
    {
        return Inscription::firstOrCreate(
            [
                'eleve_id' => $eleve_id,
                'annee_id' => $annee_id,
            ],
            [
                'eleve_id' => $eleve_id,
                'annee_id' => $annee_id,
                'classe_id' => $classe_id,
                'status' => InscriptionStatus::approved
            ]);
    }

    private static function createResponsableEleve(string $eleve_id, string $responsable_id, ResponsableRelation $relation): void
    {
        ResponsableEleve::updateOrCreate(
            [
                'eleve_id' => $eleve_id,
                'responsable_id' => $responsable_id,
            ],
            [
                'eleve_id' => $eleve_id,
                'responsable_id' => $responsable_id,
                'relation' => $relation,
            ]);
    }

}
