<?php

namespace Database\Factories;

use App\Enum\InscriptionCategorie;
use App\Enum\InscriptionStatus;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inscription>
 */
class InscriptionFactory extends Factory
{
    protected $model = Inscription::class;

    public function definition()
    {
        return [
            'eleve_id' => $this->faker->numberBetween(1, Eleve::count()),
            'classe_id' => $this->faker->numberBetween(1, Classe::count()),
            'annee_id' => Annee::encours()->id,
            'categorie' => $this->faker->randomElement(array_column(InscriptionCategorie::cases(), 'value')),
            'montant' => 100000,
            'status' => $this->faker->randomElement(array_column(InscriptionStatus::cases(), 'value')),
        ];
    }
}
