<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\FraisType;
use App\Enums\MinervalMonth;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Frais;
use App\Models\Perception;
use Exception;
use Illuminate\Support\Optional;
use Rap2hpoutre\FastExcel\FastExcel;

class PerceptionImport
{
    public function __construct(
        private readonly Frais   $frais,
        private readonly Annee   $annee,
        private readonly ?string $custom_property = null,
    )
    {
    }

    // build
    public static function build(
        Frais   $frais,
        Annee   $annee,
        ?string $custom_property = null,
    ): self
    {
        return new self(
            frais: $frais,
            annee: $annee,
            custom_property: $custom_property
        );
    }

    // import

    /**
     * @throws Exception
     */
    public function import(string $file): void
    {

        (new FastExcel)->import($file, function ($line) {
            $line = optional((array_change_key_case($line)));

            $nom = $line['nom'] ?? null;

            if ($nom) {
                $eleve = Eleve::where('nom', trim($nom))->first();

                $inscription = $eleve?->inscription;

                if ($inscription) {
                    if ($this->frais->type = FraisType::MINERVAL) {
                        $this->createMinerval(
                            eleve: $eleve,
                            frais: $this->frais,
                            line: $line,
                        );
                    }
                } else {
                    throw new Exception("L'élève {$nom} n'est pas inscrit dans une classe");
                }
            }
        });
    }

    public function createMinerval(
        Eleve    $eleve,
        Frais    $frais,
        Optional $line,
    ): void
    {
        foreach (MinervalMonth::cases() as $month) {
            if ($line[$month->value]) {
                $p = Perception::updateOrCreate([
                    'inscription_id' => $eleve->inscription->id,
                    'custom_property' => $month->value,
                ], [
                    'frais_id' => $frais->id,
                    'montant' => $line[$month->value],
                    'frais_montant' => $frais->montant,
                    'devise' => $frais->devise,
                ]);
            }
        }
    }
}
