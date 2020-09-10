<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermisosNuevosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        //Permission::create(['name' => 'verPagosPorAprobar Payments']);
        
      
   
        $role = Role::findByName('admin');
        $role->givePermissionTo('nuevoEstudiante Registration');
        $role->givePermissionTo('registrarPagoEstudiante Payments');
        $role->givePermissionTo('verEstudiantesInscritos Payments');
        $role->givePermissionTo('gestionarPago Payments');
        $role->givePermissionTo('verPagosPorAprobar Payments');

        $role1 = Role::findByName('coordinator');
        $role1->givePermissionTo('nuevoEstudiante Registration');
        $role1->givePermissionTo('registrarPagoEstudiante Payments');
        $role1->givePermissionTo('verEstudiantesInscritos Payments');
        $role1->givePermissionTo('gestionarPago Payments');
        $role1->givePermissionTo('verPagosPorAprobar Payments');
   
       
    }
}
