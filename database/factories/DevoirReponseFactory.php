<?php

namespace Database\Factories;

use App\Models\Devoir;
use App\Models\DevoirReponse;
use App\Models\Eleve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DevoirReponse>
 */
class DevoirReponseFactory extends Factory
{
    protected $model = DevoirReponse::class;

    public function definition(): array
    {
        return [
            'devoir_id' => $this->faker->randomElement(Devoir::pluck('id')->toArray()),
            'eleve_id' => $this->faker->randomElement(Eleve::pluck('id')->toArray()),
            'contenu' => $this->faker->paragraphs(5, true),
        ];
    }
}
