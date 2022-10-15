<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $option) {
            Option::updateOrCreate(['nom' => $option['nom']], $option);
        }
    }

    private function data()
    {
        return [
            [
                'nom' => 'Scientifique',
                'code' => 'SCI',
                'section_id' => 4,
            ],
            [
                'nom' => 'Pedagogique',
                'code' => 'PEDA',
                'section_id' => 4,
            ],
            [
                'nom' => 'Technique Coupe et Couture',
                'code' => 'TTC',
                'section_id' => 5,
            ],
            [
                'nom' => 'Commerciale',
                'code' => 'COM',
                'section_id' => 5,
            ],
            [
                'nom' => 'Literaire',
                'code' => 'LIT',
                'section_id' => 4,
            ],
        ];
    }
}
