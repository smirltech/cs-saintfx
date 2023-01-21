<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            $this->call([
                PermissionSeeder::class,
                AnneeSeeder::class,
                SectionSeeder::class,
                OptionSeeder::class,
                FiliereSeeder::class,
                ClasseSeeder::class,
                FraisSeeder::class,
                DepenseTypeSeeder::class,
                UnitSeeder::class,
                EtiquetteSeeder::class,
            ]);


            // create promoteur
            User::factory()->create([
                'email' => 'promoteur@cenk.cd',
                'name' => 'Promoteur',
            ])->assignRole(UserRole::promoteur->value);

            // create admin
            User::factory()->create([
                'email' => 'admin@cenk.cd',
                'name' => 'Admin',
            ])->assignRole(UserRole::promoteur->value);


            if (!app()->isProduction()) {

                User::factory()->create([
                    'email' => 'caissier@cenk.cd',
                    'name' => 'Caissier',
                ])->assignRole(UserRole::caissier->value);

                // create admin
                User::factory()->create([
                    'email' => 'eleve@cenk.cd',
                    'name' => 'Eleve',
                ])->assignRole(UserRole::eleve->value);

                User::factory()->create([
                    'email' => 'parent@cenk.cd',
                    'name' => 'Parent',
                ])->assignRole(UserRole::parent->value);

                User::factory()->create([
                    'email' => 'enseingant@cenk.cd',
                    'name' => 'Enseignant',
                ])->assignRole(UserRole::enseignant->value);

                $this->call([
                    FactorySeeder::class,
                ]);
            }
        });
    }
}
