<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
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

            Eleve::factory(10)->create();
            Inscription::factory(10)->create();

            Responsable::factory(10)->create();
            ResponsableEleve::factory(10)->create();
        }

        Schema::enableForeignKeyConstraints();

    }
}
