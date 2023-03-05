<?php

namespace App\Imports\Dto;

use App\Models\Eleve;
use App\Models\Inscription;
use Exception;

class InscriptionData
{
    public const ETUDIANT_END = 2;
    const ELEVE_NOM = 1;
    const ELEVE_SEXE = 2;
    const ELEVE_LIEU_DATE_NAISSANCE = 3;

    /**
     * @throws Exception
     */
    public static function fromRow(array $row): Inscription
    {
        $eleve = Eleve::firstOrCreate(
            [
                'nom' => $row[self::ELEVE_NOM]
            ],
            [
                'nom' => $row[self::ELEVE_NOM],
                'sexe' => $row[self::ELEVE_SEXE],
                'lieu_naissance' => self::getLieuNaissance($row[self::ELEVE_LIEU_DATE_NAISSANCE]),
                'date_naissance' => self::getDateNaissance($row[self::ELEVE_LIEU_DATE_NAISSANCE]),
            ]);

        $inscription = Inscription::firstOrCreate(
            [
                'id' => self::validateId($row[self::ELEVE_NOM])
            ],
            [
                'id' => self::validateId($row[self::ELEVE_NOM]),
                'nom' => $row[self::ETUDIANT_END]
            ]
        );

        return Inscription::find($row[self::ELEVE_NOM]);

    }

    // is valid student id

    private static function getLieuNaissance(string $value): string
    {
        $lieu = explode(',', $value);
        return trim($lieu[0]);
    }

    private static function getDateNaissance(mixed $value): string
    {
        $date = explode(',', $value);
        return trim($date[1]);
    }

    /**
     * @throws Exception
     */
    public static function validateId(string $id): int
    {
        // must have 10 digits and start with a year of 4 digits or throw an exception
        if (self::isValideId($id)) {
            return intval($id);
        }
        throw new Exception("L'identifiant de l'étudiant '{$id}' doit être un nombre de 10 chiffres");
    }

    public static function isValideId(string $id): bool|int
    {
        return preg_match('/^[0-9]{10}$/', $id);
    }

    /**
     * @throws Exception
     */
    public static function createEtudiant(array $data): Etudiant
    {
        return Etudiant::updateOrCreate([
            'id' => self::validateId($data[0]),
        ], [
            'nom' => self::validateNom($data[1]),
            'sexe' => self::validateSexe($data[2]),
        ]);
    }

    private static function validateNom(string $nom): string
    {
        return $nom;
    }

    private static function validateSexe(string $sexe): string
    {
        return $sexe;
    }
}
