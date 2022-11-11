<?php

namespace Database\Factories;

use App\Models\Enseignant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enseignant>
 */
class EnseignantFactory extends Factory
{
    protected $model = Enseignant::class;

    /*
     * nom            varchar(255) not null,
    email          varchar(255) not null,
    telephone      varchar(255) null,
    matricule      varchar(255) null,
    adresse        varchar(255) null,
    genre          varchar(255) null,
    date_naissance varchar(255) null,
    lieu_naissance varchar(255) null,
    nationalite    varchar(255) null,
    grade          varchar(255) null,
    specialite     varchar(255) null,
    diplome        varchar(255) null,
    date_embauche  varchar(255) null,
    date_depart    varchar(255) null,
    motif_depart   varchar(255) null,
    etat           varchar(255) null,
    type           varchar(255) null,
    status         varchar(255) null,
     * */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->sentence(3),
            'email' => $this->faker->sentence(3),
            'telephone' => $this->faker->sentence(3),
            'matricule' => $this->faker->sentence(3),
            'adresse' => $this->faker->sentence(3),
            'genre' => $this->faker->sentence(3),
            'date_naissance' => $this->faker->sentence(3),
            'lieu_naissance' => $this->faker->sentence(3),
            'nationalite' => $this->faker->sentence(3),
            'grade' => $this->faker->sentence(3),
            'specialite' => $this->faker->sentence(3),
            'diplome' => $this->faker->sentence(3),
            'date_embauche' => $this->faker->sentence(3),
            'date_depart' => $this->faker->sentence(3),
            'motif_depart' => $this->faker->sentence(3),
            'etat' => $this->faker->sentence(3),
            'type' => $this->faker->sentence(3),
            'status' => $this->faker->sentence(3),
        ];
    }
}
