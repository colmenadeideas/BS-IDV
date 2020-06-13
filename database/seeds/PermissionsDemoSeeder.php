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
        Permission::create(['name' => 'edit matter']);
        Permission::create(['name' => 'delete matter']);
        Permission::create(['name' => 'publish matter']);
        Permission::create(['name' => 'unpublish matter']);
        Permission::create(['name' => 'show matter']);
        Permission::create(['name' => 'notes matter']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('edit matter');
        $role1->givePermissionTo('delete matter');
        $role1->givePermissionTo('publish matter');
        $role1->givePermissionTo('unpublish matter');
        $role1->givePermissionTo('show matter');
        $role1->givePermissionTo('notes matter');


        $role2 = Role::create(['name' => 'coordinator']);
        $role2->givePermissionTo('show matter');

        $role3 = Role::create(['name' => 'teacher']);
        $role3->givePermissionTo('show matter');
        $role3->givePermissionTo('notes matter');

        $role4 = Role::create(['name' => 'student']);
        $role4->givePermissionTo('show matter');

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