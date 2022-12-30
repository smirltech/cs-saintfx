<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\MaterielCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


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
            SectionSeeder::class,
            OptionSeeder::class,
            FiliereSeeder::class,
            AnneeSeeder::class,
            ClasseSeeder::class,
            RevenuSeeder::class,
            FraisSeeder::class,
            DepenseTypeSeeder::class,
        ]);

        // create admin
        User::factory()->create([
            'email' => 'admin@cenk.cd',
            'name' => "Admin",
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ])->assignRole(UserRole::super_admin->value);

        MaterielCategory::factory()->count(3)->make();
        // if local env
        if (!app()->isProduction()) {
            $this->call([
                FactorySeeder::class,
            ]);
        }

        Schema::enableForeignKeyConstraints();

    }
}
