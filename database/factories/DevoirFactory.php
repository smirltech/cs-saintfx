<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Devoir;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Devoir>
 */
class DevoirFactory extends Factory
{
    protected $model = Devoir::class;

    /*
     * classe_id  integer not null
    references classes
    on delete restrict,
    cours_id   integer not null
    references cours
    on delete restrict,
    annee_id   integer not null
    references annees
    on delete restrict,
    titre      varchar not null,
    contenu    text,
    */
    public function definition()
    {
        return [
            'classe_id' => $this->faker->numberBetween(1, Classe::count()),
            'cours_id' => $this->faker->numberBetween(1, Cours::count()),
            'annee_id' => $this->faker->numberBetween(1, Annee::count()),
            'titre' => $this->faker->words(3, true),
            'contenu' => $this->faker->paragraphs(5, true),
        ];
    }
}
