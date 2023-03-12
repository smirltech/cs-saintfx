<?php

namespace App\Imports;

use App\Imports\Dto\InscriptionData;
use Exception;
use Rap2hpoutre\FastExcel\FastExcel;

class InscriptionsImport
{
    public function __construct(private string $annee_id, private ?string $classe_id = null)
    {
        //
    }

    // build
    public static function build(string $annee_id, string $classe_id = null): self
    {
        return new self(annee_id: $annee_id, classe_id: $classe_id = null);
    }

    // import

    /**
     * @throws Exception
     */
    public function import(string $file): void
    {
        $rows = (new FastExcel)->withoutHeaders()->import($file);

        foreach ($rows as $key => $row) {
            if ($key >= 15) {
                dd($row);
                if (!intval($row[0])) {
                    break;
                }
                InscriptionData::fromRow(data: $row, annee_id: $this->annee_id, classe_id: $this->classe_id);
            }
        }
    }
}
