<?php

namespace Database\Seeders;

use App\Enum\ClasseGrade;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Section;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $classe) {
            Classe::create($classe);
        }
    }

    private function data()
    {
        return [
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 1,
                'filierable_type' => Section::class,
            ],
            [
                'grade' => ClasseGrade::g6,
                'filierable_id' => 2,
                'filierable_type' => Filiere::class,
            ]
        ];
    }
}
