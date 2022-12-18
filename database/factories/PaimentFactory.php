<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Paiment;

/**
 * @extends Factory<Paiment>
 */
class PaimentFactory extends Factory
{
    protected $model = Paiment::class;

    public function definition()
    {
        return [
            'paimentable_type' => '',
            'paimentable_id' => 1,
            'montant' => $this->faker->randomNumber(2)*1000,
            'mois' => '',
            'motif' => $this->faker->sentence(6),
            'annee_id' => 1,
         ];
    }
}
