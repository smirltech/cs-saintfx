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
use Str;

class InscriptionData
{

    /**
     * @throws Exception
     */
    public static function fromRow(array $data, string $annee_id, ?string $classe_id): bool
    {
        $classe = self::getClasse(data: $data, classe_id: $classe_id);
        $section_id = $classe->section_id;


        $responsable = self::createResponsable(data: $data);
        $eleve = self::createEleve(data: $data, section_id: $section_id);

        if ($responsable) {
            self::createResponsableEleve(eleve_id: $eleve->id, responsable_id: $responsable?->id, relation: $data[6] ? ResponsableRelation::pere : ResponsableRelation::mere);
        }

        self::createInscription(eleve_id: $eleve->id, annee_id: $annee_id, classe_id: $classe->id);


        return true;

    }

    // is valid student id

    /**
     * @throws Exception
     */
    private static function getClasse(array $data, ?string $classe_id): Classe|null
    {
        if ($classe_id) {
            return Classe::find($classe_id);
        }

        $classe = Classe::where('code', $data[2])->first();

        if (!$classe) {
            throw new Exception('Classe ' . $data[2] . ' non trouvée, veuillez corriger le code ou créer la classe avant de continuer');
        }
        return $classe;

    }

    private static function createResponsable(array $data): ?Responsable
    {

        if ($data[6]) {
            return Responsable::updateOrCreate(
                [
                    'nom' => $data[6],
                ],
                [
                    'nom' => $data[6],
                    'profession' => $data[8],
                    'adresse' => $data[10],
                    'sexe' => Sexe::M,
                    'telephone' => $data[11],
                    'email' => $data[12],
                ]);
        }

        if ($data[7]) {
            return Responsable::updateOrCreate(
                [
                    'nom' => $data[7],
                ],
                [
                    'nom' => $data[7],
                    'profession' => $data[9],
                    'adresse' => $data[10],
                    'sexe' => Sexe::F,
                    'telephone' => $data[11],
                    'email' => $data[12],
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
                'sexe' => self::getSexe($data[3]),
                'lieu_naissance' => self::getLieuNaissance($data[4]),
                'date_naissance' => self::getDateNaissance($data[4]),
                'pere' => [
                    'nom' => $data[6],
                    'profession' => $data[8],
                ],
                'mere' => [
                    'nom' => $data[7],
                    'profession' => $data[9],
                ],
                'adresse' => $data[10],
                'telephone' => $data[11],
                'email' => $data[12],
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
        $value = Str::replace('le', '', $value);
        $date = explode(',', $value);
        if (count($date) < 2) {
            return '';
        }


        $date = explode('/', $date[1]);


        $c = Carbon::create(trim($date[2]), trim($date[1]), trim($date[0]));

        return $c->format('Y-m-d');
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

    private static function createInscription(string $eleve_id, string $annee_id, string $classe_id): void
    {
        Inscription::firstOrCreate(
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

}
