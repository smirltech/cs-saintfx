<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $depense) {
            Unit::create($depense);
        }
    }

    private function data(): array
    {
        return [
            [
                'nom' => 'Kilogramme',
                'abreviation' => 'Kg',
            ],
            [
                'nom' => 'Mètre',
                'abreviation' => 'm',
            ],
            [
                'nom' => 'Litre',
                'abreviation' => 'L',
            ],
            [
                'nom' => 'Carton',
                'abreviation' => 'Ctn',
            ],
            [
                'nom' => 'Pièce',
                'abreviation' => 'Pc',
            ],
            [
                'nom' => 'Bouteille',
                'abreviation' => 'Btl',
            ],
            [
                'nom' => 'Boîte',
                'abreviation' => 'Bte',
            ],
            [
                'nom' => 'Paquet',
                'abreviation' => 'Pqt',
            ],
            [
                'nom' => 'Sac',
                'abreviation' => 'Sac',
            ]
        ];
    }
}
