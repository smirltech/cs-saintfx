<?php

namespace Database\Seeders;

use App\Enum\PromotionGrade;
use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        //Promotion::truncate();
        foreach ($this->data() as $faculte) {
            Promotion::create($faculte);
        }
    }

    private function data()
    {
        return [
            [
                'filiere_id' => 1,
                'grade' => PromotionGrade::bac1->value,
                'code' => 'BAC1 ISI',
            ],
            [
                'filiere_id' => 1,
                'grade' => PromotionGrade::bac2->value,
                'code' => 'BAC2 ISI',
            ],
            [
                'filiere_id' => 1,
                'grade' => PromotionGrade::bac3->value,
                'code' => 'BAC3 ISI',
            ]
        ];
    }
}
