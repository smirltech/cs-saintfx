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
                TagSeeder::class,
            ]);


            // create promoteur
            User::factory()->create([
                'email' => 'promoteur@college-enk.com',
                'name' => 'Promoteur',
            ])->assignRole(UserRole::promoteur->value);

            // create admin
            User::factory()->create([
                'email' => 'admin@college-enk.com',
                'name' => 'Admin',
            ])->assignRole(UserRole::admin->value);


            if (!app()->isProduction()) {

                User::factory()->create([
                    'email' => 'caissier@college-enk.com',
                    'name' => 'Caissier',
                ])->assignRole(UserRole::caissier->value);

                // create admin
                User::factory()->create([
                    'email' => 'eleve@college-enk.com',
                    'name' => 'Eleve',
                ])->assignRole(UserRole::eleve->value);

                User::factory()->create([
                    'email' => 'parent@college-enk.com',
                    'name' => 'Parent',
                ])->assignRole(UserRole::parent->value);

                User::factory()->create([
                    'email' => 'enseingant@college-enk.com',
                    'name' => 'Enseignant',
                ])->assignRole(UserRole::enseignant->value);

                $this->call([
                    FactorySeeder::class,
                ]);
            }
        });
    }
}
