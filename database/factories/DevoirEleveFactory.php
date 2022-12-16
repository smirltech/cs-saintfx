<?php

namespace Database\Factories;

use App\Models\Devoir;
use App\Models\DevoirEleve;
use App\Models\Eleve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DevoirEleve>
 */
class DevoirEleveFactory extends Factory
{
    protected $model = DevoirEleve::class;


    /*id         varchar not null
    primary key,
    devoir_id  integer not null
    references devoirs
    on delete restrict,
    eleve_id   varchar not null
    references eleves
    on delete restrict,
    contenu    text,*/
    public function definition(): array
    {
        return [
            'devoir_id' => $this->faker->randomElement(Devoir::pluck('id')->toArray()),
            'eleve_id' => $this->faker->randomElement(Eleve::pluck('id')->toArray()),
            'contenu' => $this->faker->paragraphs(5, true),
        ];
    }
}
