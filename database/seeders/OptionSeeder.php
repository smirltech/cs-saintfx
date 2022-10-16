<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $option) {
            Option::updateOrCreate(['nom' => $option['nom']], $option);
        }
    }

    private function data()
    {
        return [
            [
                'nom' => 'Education de Base',
                'code' => 'EB',
                'section_id' => 3,
            ],
            [
                'nom' => 'Humanité',
                'code' => 'HUM',
                'section_id' => 3,
            ],
            [
                'nom' => 'Technique',
                'code' => 'TEC',
                'section_id' => 3,
            ],

        ];
    }
}
