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
       // Permission::create(['name' => 'nuevoPeriodo Registration']);
      


        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'coordinador']);
        $role3 = Role::create(['name' => 'profesor']);
        $role4 = Role::create(['name' => 'estudiante']);


        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        /*
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
        */
    }
}