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

        // Create Super Admin role and assign to the first user
        $roleAdmin = Role::create(['name' => 'Super Admin']);

        foreach (config('permission.permissions') as $permission) {
            foreach ($permission['access'] as $access) {
                Permission::create(['name' => $access]);
            }
        }

        $userAdmin = User::first();
        $userAdmin->assignRole('Super Admin');
        $roleAdmin->givePermissionTo(Permission::all());

        // Create Admin RS role and assign permissions
        $roleAdminRs = Role::create(['name' => 'Admin RS']);
        $permissionAdminUnit = [
            'user view',
            'user create',
            'user edit',
            'user delete',
            // 'role & permission view',
            // 'role & permission create',
            // 'role & permission edit',
            // 'role & permission delete',
            'department view',
            'department create',
            'department edit',
            'department delete',
            'position view',
            'position create',
            'position edit',
            'position delete',
            'unit item view',
            'unit item create',
            'unit item edit',
            'unit item delete',
            'equipment location view',
            'equipment location create',
            'equipment location edit',
            'equipment location delete',
            'employee type view',
            'employee type create',
            'employee type edit',
            'employee type delete',
            'employee type view',
            'employee type create',
            'employee type edit',
            'employee type delete',
            'employee view',
            'employee create',
            'employee edit',
            'employee delete',
            'category vendor view',
            'category vendor create',
            'category vendor edit',
            'category vendor delete',
            'vendor view',
            'vendor create',
            'vendor edit',
            'vendor delete',
            'equipment view',
            'equipment create',
            'equipment edit',
            'equipment delete',
            'sparepart view',
            'sparepart create',
            'sparepart edit',
            'sparepart delete',
            'download qr',
            'sparepart stock in',
            'sparepart stock out',
            'sparepart history',
            'loan view',
            'loan create',
            'loan edit',
            'loan delete',
            'activity log view',
            'nomenklatur view',
            'kalender wo view',
            'work order view',
            'work order create',
            'work order edit',
            'work order delete',
            'work order approval',
            'work order process',
        ];
        foreach ($permissionAdminUnit as $x) {
            $roleAdminRs->givePermissionTo($x);
        }

        // Find user with id 2 and assign them the Admin RS role
        $user = User::find(2);
        if ($user) {
            $user->assignRole('Admin RS');
        }
    }
}
