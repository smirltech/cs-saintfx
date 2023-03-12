<?php

namespace Database\Seeders;

use App\Enums\ClasseGrade;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Option;
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
                'code' => '1MAT',
            ],
            [
                'grade' => ClasseGrade::g2,
                'filierable_id' => 1,
                'filierable_type' => Section::class,
                'code' => '2MAT',
            ],
            [
                'grade' => ClasseGrade::g3,
                'filierable_id' => 1,
                'filierable_type' => Section::class,
                'code' => '3MAT',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code' => ClasseGrade::g1,
            ],
            [
                'grade' => ClasseGrade::g2,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code' => ClasseGrade::g2,
            ],
            [
                'grade' => ClasseGrade::g3,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code' => ClasseGrade::g3,
            ],
            [
                'grade' => ClasseGrade::g4,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code' => ClasseGrade::g4,
            ],
            [
                'grade' => ClasseGrade::g5,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code' => ClasseGrade::g5,
            ],
            [
                'grade' => ClasseGrade::g6,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code' => ClasseGrade::g6,
            ],
            [
                'grade' => ClasseGrade::g7,
                'filierable_id' => 1,
                'filierable_type' => Option::class,
                'code' => ClasseGrade::g7,
            ],
            [
                'grade' => ClasseGrade::g8,
                'filierable_id' => 1,
                'filierable_type' => Option::class,
                'code' => ClasseGrade::g8,
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 1,
                'filierable_type' => Filiere::class,
                'code' => '1HP',
            ],
            [
                'grade' => ClasseGrade::g2,
                'filierable_id' => 1,
                'filierable_type' => Filiere::class,
                'code' => '2HP',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 2,
                'filierable_type' => Filiere::class,
                'code' => '1HL',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 3,
                'filierable_type' => Filiere::class,
                'code' => '1HS',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 4,
                'filierable_type' => Filiere::class,
                'code' => '1MEC',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 5,
                'filierable_type' => Filiere::class,
                'code' => '1ELE',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 6,
                'filierable_type' => Filiere::class,
                'code' => '1TCC',
            ],
        ];
    }
}
