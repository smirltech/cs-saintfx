<?php

namespace App\Imports;

use App\Imports\Dto\EtudiantData;
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
            if (EtudiantData::isValideId($line[0])) {
                return EtudiantData::createEtudiant($line);
            }
            return null;
        });
    }
}
