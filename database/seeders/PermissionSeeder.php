<?php

namespace Database\Seeders;

use App\Enums\RolePermission;
use App\Enums\UserRole;
use App\Models\Permission;
use App\Models\Role;
use DB;
use Illuminate\Database\Seeder;
use Schema;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *
     * @return void
     */
    public function run()
    {


        // if local environment, delete all permissions and roles
        if (app()->environment('local')) {
            Schema::disableForeignKeyConstraints();
            DB::table('permissions')->truncate();
            DB::table('roles')->truncate();
            DB::table('role_has_permissions')->truncate();
            DB::table('model_has_roles')->truncate();
            Schema::enableForeignKeyConstraints();
        }


        // crate bulk permissions
        foreach (RolePermission::cases() as $permission) {
            Permission::create(['name' => $permission->name]);
        }

        foreach (UserRole::cases() as $userRole) {
            $role = Role::create(['name' => $userRole->name]);
            $role->givePermissionTo($userRole->permissions());
        }
    }
}
