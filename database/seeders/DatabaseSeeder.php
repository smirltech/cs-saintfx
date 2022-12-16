<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ClasseEnseignant;
use App\Models\Cours;
use App\Models\CoursEnseignant;
use App\Models\Devoir;
use App\Models\DevoirEleve;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Inscription;
use App\Models\Presence;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Models\Resultat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            SectionSeeder::class,
            OptionSeeder::class,
            FiliereSeeder::class,
            AnneeSeeder::class,
            ClasseSeeder::class,
        ]);


        // if local env
        if (app()->environment('local')) {
            User::factory(10)->create();

            Eleve::factory(30)->create();
            Inscription::factory(30)->create();

            Responsable::factory(30)->create();
            ResponsableEleve::factory(30)->create();

            Enseignant::factory(30)->create();
            ClasseEnseignant::factory(10)->create();

            Cours::factory(30)->create();
            CoursEnseignant::factory(20)->create();

            Presence::factory(30)->create();

            Resultat::factory(30)->create();

            Devoir::factory(30)->create();
            DevoirEleve::factory(30)->create();


        }

        Schema::enableForeignKeyConstraints();

    }
}
