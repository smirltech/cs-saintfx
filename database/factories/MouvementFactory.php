<?php

namespace Database\Factories;

use App\Enums\MaterialStatus;
use App\Models\Materiel;
use App\Models\Mouvement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mouvement>
 */
class MouvementFactory extends Factory
{
    protected $model = Mouvement::class;

    public function definition()
    {

        return [
            'materiel_id' => $this->faker->randomElement(Materiel::pluck('id')->toArray()),
            'borrower_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'lender_out_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'date_out' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status_out' => $this->faker->randomElement(MaterialStatus::cases()),
        ];
    }
}
