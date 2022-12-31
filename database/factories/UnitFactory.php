<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition()
    {
        $um = $this->faker->unique()->randomElement(['Kilogramme', 'Litre', 'Carton', 'Piece', 'Bouteille']);
        return [
            'nom' => $um, //$this->faker->word,
            'abreviation' => Str::limit( $um, $limit = 3, $end = ''),
        ];
    }
}
