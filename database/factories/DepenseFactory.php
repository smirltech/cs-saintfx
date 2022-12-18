<?php

namespace Database\Factories;

use App\Enums\DepenseCategorie;
use App\Models\Depense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Perception;

/**
 * @extends Factory<Perception>
 */
class DepenseFactory extends Factory
{
    protected $model = Depense::class;

    public function definition()
    {
        return [
            'categorie' => $this->faker->randomElement(array_column(DepenseCategorie::cases(), 'value')),
            'montant' => $this->faker->randomNumber(2)*1000,
            'note' => $this->faker->sentence(6),
            'reference' => $this->faker->randomNumber(6),
            'annee_id' => 1,
            'user_id' => $this->faker->numberBetween(1, User::count()),
        ];
    }
}
