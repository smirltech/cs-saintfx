<?php

namespace Database\Factories;

use App\Enums\MaterialStatus;
use App\Models\Amortissement;
use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Amortissement>
 */
class AmortissementFactory extends Factory
{
    protected $model = Amortissement::class;

    public function definition()
    {

        return [
            'materiel_id' => $this->faker->randomElement(Materiel::pluck('id')->toArray()),
            'date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
           'montant' => $this->faker->numberBetween(1000, 5000),
        ];
    }
}
