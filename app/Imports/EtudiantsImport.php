<?php

namespace App\Imports;

use App\Imports\Dto\InscriptionData;
use Exception;
use Rap2hpoutre\FastExcel\FastExcel;

class EtudiantsImport
{
    public function __construct()
    {
        //
    }

    // build
    public static function build(): self
    {
        return new self();
    }

    // import

    /**
     * @throws Exception
     */
    public function import(string $file): void
    {
        (new FastExcel)->withoutHeaders()->import($file, function ($line) {
            if (InscriptionData::isValideId($line[0])) {
                return InscriptionData::createEtudiant($line);
            }
            return null;
        });
    }
}
