<?php

namespace Database\Factories;

use App\Models\Eleve;
use App\Models\Presence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Presence>
 */
class PresenceFactory extends Factory
{
    protected $model = Presence::class;

    /*
     *
     eleve_id    bigint unsigned not null,
    date        date            not null,
    observation text            null,
     */
    public function definition()
    {
        return [
            'eleve_id' => $this->faker->numberBetween(1, Eleve::count()),
            'date' => $this->faker->date(),
            'observation' => $this->faker->sentence(3),
        ];
    }
}
