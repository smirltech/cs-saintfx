<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Cours;
use App\Models\CoursEnseignant;
use App\Models\Enseignant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CoursEnseignant>
 */
class CoursEnseignantFactory extends Factory
{
    protected $model = CoursEnseignant::class;

    public function definition()
    {
        return [
            'cours_id' => $this->faker->numberBetween(1, Cours::count()),
            'enseignant_id' => $this->faker->numberBetween(1, Enseignant::count()),
            'annee_id' => $this->faker->numberBetween(1, Annee::count()),
        ];
    }
}
