<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\EnseignantCours;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EnseignantCours>
 */
class EnseignantCoursFactory extends Factory
{
    protected $model = EnseignantCours::class;

    public function definition()
    {
        return [
            'cours_id' => $this->faker->numberBetween(1, Cours::count()),
            'enseignant_id' => $this->faker->numberBetween(1, Enseignant::count()),
            'annee_id' => $this->faker->numberBetween(1, Annee::count()),
        ];
    }
}
