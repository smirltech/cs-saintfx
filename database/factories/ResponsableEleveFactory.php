<?php

namespace Database\Factories;

use App\Enum\ResponsableRelation;
use App\Models\Eleve;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResponsableEleve>
 */
class ResponsableEleveFactory extends Factory
{
    protected $model = ResponsableEleve::class;

    public function definition()
    {
        return [
            'responsable_id' => $this->faker->numberBetween(1, Responsable::count()),
            'eleve_id' => $this->faker->numberBetween(1, Eleve::count()),
            'relation' => $this->faker->randomElement(array_column(ResponsableRelation::cases(), 'value')),
        ];
    }
}
