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
                'nom' => 'Biologie Chimie',
                'code' => 'BC',
                'option_id' => 1,
            ],
            [
                'nom' => 'Mathematique Physique',
                'code' => 'MP',
                'option_id' => 1,
            ],

        ];
    }
}
