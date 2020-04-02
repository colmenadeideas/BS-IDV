<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit schudele']);
        Permission::create(['name' => 'delete schudele']);
        Permission::create(['name' => 'publish schudele']);
        Permission::create(['name' => 'unpublish schudele']);
        Permission::create(['name' => 'show schudele']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('edit schudele');
        $role1->givePermissionTo('delete schudele');
        $role1->givePermissionTo('publish schudele');
        $role1->givePermissionTo('unpublish schudele');
        $role1->givePermissionTo('show schudele');


        $role2 = Role::create(['name' => 'coordinator']);
        $role2->givePermissionTo('show schudele');

        $role3 = Role::create(['name' => 'teacher']);
        $role3->givePermissionTo('show schudele');

        $role4 = Role::create(['name' => 'student']);
        $role4->givePermissionTo('show schudele');

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = Factory(App\User::class)->create([
            'name' => 'Pedro Perez',
            'email' => 'admin@idv.com.ve',
        ]);
        $user->assignRole($role1);

        $user = Factory(App\User::class)->create([
            'name' => 'Axel Jose',
            'email' => 'coordinator@idv.com.ve',
        ]);
        $user->assignRole($role2);

        $user = Factory(App\User::class)->create([
            'name' => 'Salem Ortega',
            'email' => 'teacher@idv.com.ve',
        ]);
        $user->assignRole($role3);

        $user = Factory(App\User::class)->create([
            'name' => 'Cinthia Quintero',
            'email' => 'student@idv.com.ve',
        ]);
        $user->assignRole($role4);
    }
}