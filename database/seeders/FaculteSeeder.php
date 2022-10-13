<?php

namespace Database\Seeders;

use App\Models\Faculte;
use Illuminate\Database\Seeder;

class FaculteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Faculte::truncate();
        foreach ($this->data() as $faculte) {
            Faculte::create($faculte);
        }
    }

    private function data()
    {
        return [
            [
                'nom' => 'Théologie',
                'code' => 'TH',
                'email' => 'theologie@upl-univ.ac',
            ],
            [
                'nom' => 'Informatiques',
                'code' => 'INFO',
                'email' => 'facinfo@upl-univ.ac',
            ],
            [
                'nom' => 'Sciences de l’Information et de la Communication',
                'code' => 'SIC',
                'email' => 'sic@upl-univ.ac',
            ],
            [
                'nom' => 'Sciences Économiques et Management',
                'code' => 'ECM',
                'email' => 'economie@upl-univ.ac',
            ],
            [
                'nom' => 'Lettres et Sciences Humaines',
                'code' => 'LSH',
                'email' => 'lettres@upl-univ.ac',
            ],
            [
                'nom' => 'Droit',
                'code' => 'DR',
                'email' => 'droit@upl-univ.ac',
            ],
            [
                'nom' => 'Polytechnique',
                'code' => 'POLY',
                'email' => 'poly@upl-univ.ac',
            ],

        ];
    }
}
