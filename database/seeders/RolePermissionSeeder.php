<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleCliente = Role::create(['name' => 'cliente']);

        $user = User::find(1);
        $user->assignRole($roleAdmin);

        $permission = Permission::create(['name' => 'user.index']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'user.create']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'user.edit']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'user.delete']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'user.show']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'producto.index']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'producto.create']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'producto.edit']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'producto.show']);
        $permission->assignRole($roleAdmin);
        $permission = Permission::create(['name' => 'producto.delete']);
        $permission->assignRole($roleAdmin);
    }
}
