<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
            SectionSeeder::class,
            OptionSeeder::class,
            FiliereSeeder::class,
            AnneeSeeder::class,
            ClasseSeeder::class,
            RevenuSeeder::class,
            FraisSeeder::class,
        ]);

        // create admin
        User::factory()->create([
            'email' => 'admin@cenk.cd',
            'name' => "Admin",
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ])->assignRole(UserRole::super_admin->value);


        // if local env
        if (!app()->isProduction()) {
            $this->call([
                FactorySeeder::class,
            ]);
        }

        Schema::enableForeignKeyConstraints();

    }
}
