<?php

namespace Database\Factories;

use App\Models\Revenu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Perception;

/**
 * @extends Factory<Perception>
 */
class RevenuFactory extends Factory
{
    protected $model = Revenu::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(6),
            'montant' => $this->faker->randomNumber(2)*1000,
            'annee_id' => 1,
        ];
    }
}
