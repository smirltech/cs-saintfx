<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ClasseEnseignant;
use App\Models\Cours;
use App\Models\CoursEnseignant;
use App\Models\Depense;
use App\Models\Devoir;
use App\Models\DevoirReponse;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\Perception;
use App\Models\Presence;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Models\Resultat;
use App\Models\Revenu;
use App\Models\User;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {

        User::factory(5)->create();

        Eleve::factory(10)->create();
        Inscription::factory(10)->create();

        Responsable::factory(10)->create();
        ResponsableEleve::factory(10)->create();

        Enseignant::factory(10)->create();
        ClasseEnseignant::factory(10)->create();

        Cours::factory(10)->create();
        CoursEnseignant::factory(20)->create();

        Presence::factory(10)->create();

        Resultat::factory(10)->create();

        Devoir::factory(10)->create();
        DevoirReponse::factory(10)->create();

        # Finance
        Revenu::factory(5)->create();
        Depense::factory(5)->create();
        Paiment::factory(5)->create();
        Perception::factory(5)->create();

    }
}
