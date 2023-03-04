<?php

namespace App\Imports;

use App\Enums\DeliberationType;
use App\Imports\Dto\ComplementData;
use App\Imports\Dto\CotationData;
use App\Imports\Dto\CoursData;
use App\Imports\Dto\DeliberationData;
use App\Imports\Dto\EtudiantData;
use Exception;
use Rap2hpoutre\FastExcel\FastExcel;

class DeliberationsImport
{
    public function __construct(private string $promotion_code, private string $annee, private string $type)
    {
        //
    }

    // build
    public static function build(string $promotion_code, string $annee, string $type): self
    {
        return new self($promotion_code, $annee, $type);
    }

    // import

    /**
     * @throws Exception
     */
    public function import(string $file): void
    {
        $DELIBERATION_START = 0;
        $rows = (new FastExcel)->withoutHeaders()->import($file);
        $cours = [];

        foreach ($rows as $key => $row) {
            if ($key == 3) { # 3 pour les cours, soit ligne 4
                // find SESSION in $row and get the index
                $DELIBERATION_START = array_search(CoursData::COURS_DELIMITER, $row);
                $cours = $row;
            }
            if ($key == 4) { # 4 pour les credits, soit ligne 5

                $credits = $row;
            }
            if ($key >= 7) { # 6 pour les cotes, soit ligne 8
                #1: On cherche l'etudiant ou on le cree
                $etudiant = EtudiantData::fromRow($row);

                if ($this->type == DeliberationType::resultats->value) {
                    #2: On met a jour les cotes ou on les cree
                    CotationData::fromRow(
                        cotes: $row,
                        cours: $cours,
                        credits: $credits,
                        etudiant: $etudiant,
                        promotion_code: $this->promotion_code,
                        annee: $this->annee
                    );
                    #3: On cree les deliberations
                    DeliberationData::fromRow(
                        row: $row,
                        etudiant: $etudiant,
                        promotion_code: $this->promotion_code,
                        annee: $this->annee,
                        deliberation_start: $DELIBERATION_START
                    );
                } elseif ($this->type == DeliberationType::complements->value) {
                    #2: On met a jour les cotes de complement ou on les cree
                    ComplementData::fromRow(
                        cotes: $row,
                        cours: $cours,
                        credits: $credits,
                        etudiant: $etudiant,
                        promotion_code: $this->promotion_code,
                        annee: $this->annee
                    );

                }
            }
        }
    }
}
