<?php

namespace App\Imports;

use App\Enums\DeliberationType;
use App\Imports\Dto\InscriptionData;
use Exception;
use Rap2hpoutre\FastExcel\FastExcel;

class InscriptionsImport
{
    public function __construct(private string $annee_id, private string $classe_id)
    {
        //
    }

    // build
    public static function build(string $annee_id, string $classe_id): self
    {
        return new self(annee_id: $annee_id, classe_id: $classe_id);
    }

    // import

    /**
     * @throws Exception
     */
    public function import(string $file): void
    {
        $rows = (new FastExcel)->withoutHeaders()->import($file);

        foreach ($rows as $key => $row) {
            if ($key >= 15) { # 6 pour les cotes, soit ligne 8
                if ($row[5]) {
                    $section = $row[5];
                    continue;
                }
                $inscription = InscriptionData::fromRow($row);
            }
        }
    }
}
