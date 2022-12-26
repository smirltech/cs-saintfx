<?php

namespace Database\Seeders;

use App\Models\Annee;
use Illuminate\Database\Seeder;

class AnneeSeeder extends Seeder
{
    public function run()
    {
        Annee::updateOrCreate(['nom' => "2022-2023"], [
            'nom' => '2022',
            'encours' => true,
        ]);
    }
}
