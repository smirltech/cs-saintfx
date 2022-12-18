<?php

namespace Database\Factories;

use App\Models\Frais;
use App\Models\Perception;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perception>
 */
class PerceptionFactory extends Factory
{
    protected $model = Perception::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'frais_id' => $this->faker->numberBetween(1, Frais::count()),
            'inscription_id' => $this->faker->numberBetween(1, 10),
            'custom_property' => $this->faker->word,
            'annee_id' => 1,
            'montant' => 50000,
            'paid' => $this->faker->numberBetween(30000, 55000),
            'paid_by' => $this->faker->word,
        ];
    }
}
