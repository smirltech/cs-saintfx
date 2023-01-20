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
                $this->call([
                    FactorySeeder::class,
                ]);
            }
        });
    }
}
