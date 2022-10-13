<?php

namespace Database\Seeders;

use App\Models\Filiere;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    public function run()
    {
//        Filiere::truncate();
        foreach ($this->data() as $faculte) {
            Filiere::create($faculte);
        }
    }

    private function data()
    {
        return [
            [
                'nom' => 'Ingenierie des Systemes Informatiques',
                'code' => 'ISI',
                'faculte_id' => 2,
            ],
            [
                'nom' => 'Réseaux et Telecommunication',
                'code' => 'RT',
                'faculte_id' => 2,
            ],
            [
                'nom' => 'Informatique de Gestion',
                'code' => 'IG',
                'faculte_id' => 2,
            ]

        ];
    }
}
