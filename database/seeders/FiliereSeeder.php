<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    public function run()
    {
//        Option::truncate();
        foreach ($this->data() as $faculte) {
            Option::create($faculte);
        }
    }

    private function data()
    {
        return [
            [
                'nom' => 'Pédagogie Générale',
                'code' => 'PG',
                'option_id' => 2,
            ],
            [
                'nom' => 'Literaire',
                'code' => 'LT',
                'option_id' => 2,
            ],
            [
                'nom' => 'Scientifique',
                'code' => 'SCI',
                'option_id' => 2,
            ],
            [
                'nom' => 'Mécanique',
                'code' => 'MEC',
                'option_id' => 3,
            ],
            [
                'nom' => 'Éléctricité',
                'code' => 'ELE',
                'option_id' => 3,
            ],
            [
                'nom' => 'Coupe et Couture',
                'code' => 'TCC',
                'option_id' => 3,
            ],
        ];
    }
}
