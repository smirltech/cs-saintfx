<?php

namespace Database\Factories;

use App\Enum\Sexe;
use App\Models\Responsable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Responsable>
 */
class ResponsableFactory extends Factory
{
    protected $model = Responsable::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->nom,
            'sexe' => $this->faker->randomElement(array_column(Sexe::cases(), 'value')),
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
        ];
    }
}
