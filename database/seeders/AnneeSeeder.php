<?php

namespace Database\Seeders;

use App\Models\Annee;
use Illuminate\Database\Seeder;

class AnneeSeeder extends Seeder
{
    public function run()
    {
        Annee::updateOrCreate(
            ['date_debut' => "2022-09-05",'date_fin' => "2023-07-05"],
            ['encours' => true,]
        );
    }
}
