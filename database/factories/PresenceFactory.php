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

    public function definition()
    {
        return [
            'eleve_id' => $this->faker->randomElement(Eleve::pluck('id')->toArray()),
            'date' => $this->faker->date(),
            'observation' => $this->faker->sentence(3),
        ];
    }
}
