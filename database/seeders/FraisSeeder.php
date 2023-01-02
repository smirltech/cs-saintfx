<?php

namespace Database\Seeders;

use App\Enums\FraisFrequence;
use App\Enums\FraisType;
use App\Models\Annee;
use App\Models\Frais;
use Illuminate\Database\Seeder;

class FraisSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $frais) {
            Frais::create($frais);
        }
    }

    private function data(): array
    {
        return [
            [
                'nom' => 'Frais d\'inscription',
                'description' => 'Frais d\'inscription',
                'montant' => 50000,
                'classable_id' => 1,
                'classable_type' => 'App\Models\Section',
                'annee_id' => Annee::id(),
                'frequence' => FraisFrequence::annuel,
                'type' => FraisType::inscription
            ],
        ];
    }
}
