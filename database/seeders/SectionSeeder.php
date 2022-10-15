<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $section) {
            Section::updateOrCreate(['nom' => $section['nom']], $section);
        }

    }

    private function data()
    {
        return [
            [
                'nom' => 'Maternelle',
            ],
            [
                'nom' => 'Primaire',
            ],
            [
                'nom' => 'Secondaire',
            ],
            [
                'nom' => 'Humanitaire',
            ],
            [
                'nom' => 'Technique',
            ],
        ];
    }
}
