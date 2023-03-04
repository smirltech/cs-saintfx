<?php

namespace App\Imports;

use App\Enums\DeliberationType;
use App\Imports\Dto\InscriptionData;
use Exception;
use Rap2hpoutre\FastExcel\FastExcel;

class InscriptionsImport
{
    public function __construct(private string $annee)
    {
        //
    }

    // build
    public static function build(string $annee): self
    {
        return new self(annee: $annee);
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
