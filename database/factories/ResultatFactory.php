<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Resultat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Resultat>
 */
class ResultatFactory extends Factory
{
    protected $model = Resultat::class;

    public function definition()
    {
        return [
            'custom_property' => $this->faker->word,
            'pourcentage' => $this->faker->randomFloat(2, 0, 100),
            'place' => $this->faker->word,
            'annee_id' => $this->faker->numberBetween(1, Annee::count()),
            'eleve_id' => $this->faker->randomElement(Eleve::pluck('id')->toArray()),
        ];
    }
}
