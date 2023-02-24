<?php

namespace Database\Factories;

use App\Models\OuvrageCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OuvrageCategory>
 */
class OuvrageCategoryFactory extends Factory
{
    protected $model = OuvrageCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->text(20),
            // 'rayon_id' => $this->faker->randomElement(OuvrageCategory::pluck('id')->toArray()),
            'description' => fake()->paragraph(3),
        ];
    }
}
