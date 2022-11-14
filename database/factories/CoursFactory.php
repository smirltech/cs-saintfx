<?php

namespace Database\Factories;

use App\Models\Cours;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cours>
 */
class CoursFactory extends Factory
{
    protected $model = Cours::class;

    /*
     nom         varchar(255) not null,
    code        varchar(255) not null,
    description text null,
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->sentence(3),
            'code' => $this->faker->randomNumber(3),
            'description' => $this->faker->sentence(3),
        ];
    }
}
