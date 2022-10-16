<?php

namespace Database\Seeders;

use App\Enum\ClasseGrade;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Section;
use Illuminate\Database\Seeder;
use App\Models\Option;

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
                'code'=>'1e',
            ],
            [
                'grade' => ClasseGrade::g2,
                'filierable_id' => 1,
                'filierable_type' => Section::class,
                'code'=>'2e',
            ],
            [
                'grade' => ClasseGrade::g3,
                'filierable_id' => 1,
                'filierable_type' => Section::class,
                'code'=>'3e',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code'=>'1e',
            ],
            [
                'grade' => ClasseGrade::g2,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code'=>'2e',
            ],
            [
                'grade' => ClasseGrade::g3,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code'=>'3e',
            ],
            [
                'grade' => ClasseGrade::g4,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code'=>'4e',
            ],
            [
                'grade' => ClasseGrade::g5,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code'=>'5e',
            ],
            [
                'grade' => ClasseGrade::g6,
                'filierable_id' => 2,
                'filierable_type' => Section::class,
                'code'=>'6e',
            ],
            [
                'grade' => ClasseGrade::g7,
                'filierable_id' => 1,
                'filierable_type' => Option::class,
                'code'=>'7e EB',
            ],
            [
                'grade' => ClasseGrade::g8,
                'filierable_id' => 1,
                'filierable_type' => Option::class,
                'code'=>'8e EB',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 1,
                'filierable_type' => Filiere::class,
                'code'=>'1e HP',
            ],
            [
                'grade' => ClasseGrade::g2,
                'filierable_id' => 1,
                'filierable_type' => Filiere::class,
                'code'=>'2e HP',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 2,
                'filierable_type' => Filiere::class,
                'code'=>'1e HL',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 3,
                'filierable_type' => Filiere::class,
                'code'=>'1e HS',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 4,
                'filierable_type' => Filiere::class,
                'code'=>'1e MEC',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 5,
                'filierable_type' => Filiere::class,
                'code'=>'1e ELE',
            ],
            [
                'grade' => ClasseGrade::g1,
                'filierable_id' => 6,
                'filierable_type' => Filiere::class,
                'code'=>'1e TCC',
            ],
        ];
    }
}
