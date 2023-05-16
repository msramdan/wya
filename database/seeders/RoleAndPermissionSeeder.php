<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleAdmin = Role::create(
            [
                'name' => 'Super Admin',
                'hospital_id' => null
            ]
        );

        $roleAdminRs = Role::create(
            [
                'name' => 'Admin Rs Bogor',
                'hospital_id' => 1
            ]
        );

        foreach (config('permission.permissions') as $permission) {
            foreach ($permission['access'] as $access) {
                Permission::create(['name' => $access]);
            }
        }

        $userAdmin = User::first();
        $userAdmin->assignRole('Super Admin');
        $roleAdmin->givePermissionTo(Permission::all());

        $userAdminRs = User::find(2);
        $userAdminRs->assignRole('Admin Rs Bogor');
        $roleAdminRs->givePermissionTo(Permission::all());
    }
}
