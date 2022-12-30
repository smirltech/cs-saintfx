<?php

namespace Database\Factories;

use App\Enums\FraisFrequence;
use App\Models\Annee;
use App\Models\Frais;
use App\Models\Inscription;
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
        $freq = $this->faker->randomElement(FraisFrequence::cases());
       // dd($freq);
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'frais_id' => $this->faker->randomElement(Frais::pluck('id')->toArray()),
            'inscription_id' => $this->faker->randomElement(Inscription::pluck('id')->toArray()),
            'frequence' => $freq->name,
            'custom_property' => $this->faker->randomElement($freq->children()),
            'annee_id' => $this->faker->numberBetween(1, Annee::count()),
            'montant' => 50000,
            'paid' => $this->faker->numberBetween(30000, 55000),
            'paid_by' => $this->faker->word,
        ];
    }
}

