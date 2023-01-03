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
        $this->call([
            PermissionSeeder::class,
            SectionSeeder::class,
            OptionSeeder::class,
            FiliereSeeder::class,
            AnneeSeeder::class,
            ClasseSeeder::class,
            FraisSeeder::class,
            DepenseTypeSeeder::class,
            UnitSeeder::class,
        ]);

        // create admin
        User::factory()->create([
            'email' => 'admin@cenk.cd',
            'name' => "Admin",
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
        ])->assignRole(UserRole::super_admin->value);

            if (!app()->isProduction()) {
                $this->call([
                    FactorySeeder::class,
                ]);
            }
        }

    }
}
