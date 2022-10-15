<?php

namespace Database\Factories;

use App\Enum\Sexe;
use App\Models\Eleve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Eleve>
 */
class EleveFactory extends Factory
{
    protected $model = Eleve::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->firstName,
            'prenom' => $this->faker->firstName,
            'postnom' => $this->faker->lastName,
            'sexe' => $this->faker->randomElement(array_column(Sexe::cases(), 'value')),
            'date_naissance' => $this->faker->date(),
            'lieu_naissance' => $this->faker->city,
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'matricule' => $this->faker->unique()->randomNumber(8),
        ];
    }
}
