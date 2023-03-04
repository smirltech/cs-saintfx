<?php

namespace App\Imports\Dto;

use App\Models\Etudiant;
use Exception;

class EtudiantData
{
    public const ETUDIANT_END = 2;
    const ETUDIANT_START = 1;

    /**
     * @throws Exception
     */
    public static function fromRow(array $row): Etudiant
    {
        Etudiant::firstOrCreate(
            [
                'id' => self::validateId($row[self::ETUDIANT_START])
            ],
            [
                'id' => self::validateId($row[self::ETUDIANT_START]),
                'nom' => $row[self::ETUDIANT_END]
            ]
        );

        return Etudiant::find($row[self::ETUDIANT_START]);

    }

    // is valid student id

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
