<?php

namespace Database\Seeders;


use App\Models\Etiquette;
use Illuminate\Database\Seeder;

class EtiquetteSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $etiquette) {
            Etiquette::create($etiquette);
        }
    }

    private function data()
    {
        return [
            [
                'nom' => 'Sciences',
            ],
            [
                'nom' => 'Langue',
            ],
            [
                'nom' => 'Technologie',
            ],
            [
                'nom' => 'Connaissance Générale',
            ],
            [
                'nom' => 'Biologie',
            ],
            [
                'nom' => 'Électricité',
            ],
            [
                'nom' => 'Français',
            ],
            [
                'nom' => 'Agriculture',
            ],
        ];
    }
}
