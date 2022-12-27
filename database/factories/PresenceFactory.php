<?php

namespace Database\Factories;

use App\Enums\PresenceStatus;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Presence;
use Carbon\Carbon;
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
            'inscription_id' => $this->faker->randomElement(Inscription::pluck('id')->toArray()),
            'status' => $this->faker->randomElement(PresenceStatus::cases()),
            'date' => Carbon::now()->subDays($this->faker->numberBetween(1,4))->format('Y-m-d'),
            'observation' => $this->faker->sentence(3),
            'annee_id' => Annee::id(),
        ];
    }
}
