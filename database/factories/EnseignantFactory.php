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
            'nom' => $this->faker->name(),
            'email' => $this->faker->email(),
            'telephone' => $this->faker->phoneNumber(),
            'matricule' => $this->faker->uuid(),
            'adresse' => $this->faker->address(),
            'genre' => $this->faker->randomElement(['M', 'F']),
            'date_naissance' => $this->faker->date(),
            'lieu_naissance' => $this->faker->city(),
            'nationalite' => $this->faker->country(),
            'grade' => $this->faker->sentence(3),
            'specialite' => $this->faker->sentence(3),
            'diplome' => $this->faker->sentence(3),
            'date_embauche' => $this->faker->date(),
            'date_depart' => $this->faker->date(),
            'motif_depart' => $this->faker->sentence(3),
            'status' => $this->faker->sentence(3),
        ];
    }
}
