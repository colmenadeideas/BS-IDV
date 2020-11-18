<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Str;
use App\User; 
class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profesor[0] = array('nombre' =>  'Francis','apellido' =>  'V. Sierra', 'email' =>  'francisvsierra@gmail.com');
        $profesor[1] = array('nombre' =>  'Patty','apellido' =>  'Sierra', 'email' =>  'patriciavsierra@gmail.com');
        $profesor[2] = array('nombre' =>  'Freddy','apellido' =>  'Balza', 'email' =>  'balzaidc@hotmail.com');
        $profesor[3] = array('nombre' =>  'Genesis','apellido' =>  'Hernandez', 'email' =>  'barbghr@gmail.com');
        $profesor[4] = array('nombre' =>  'Juliette','apellido' =>  'Millan', 'email' =>  'juliettemillan@gmail.com');
        $profesor[5] = array('nombre' =>  'Nelson','apellido' =>  'Sierra', 'email' =>  'idvnelsons@gmail.com');
        $profesor[6] = array('nombre' =>  'Monica','apellido' =>  'Galasso', 'email' =>  'monica.galasso@gmail.com');
        $profesor[7] = array('nombre' =>  'Guevara ','apellido' =>  'Oliver', 'email' =>  'oliarturo@gmail.com');
        $profesor[8] = array('nombre' =>  'Yris','apellido' =>  'Rodriguez', 'email' =>  'maryelis_1306@hotmail.com');
        $profesor[9] = array('nombre' =>  'Giusepe','apellido' =>  'Roman', 'email' =>  'gromangiannini@gmail.com');
        $profesor[10] = array('nombre' =>  'Jose','apellido' =>  'Tovar', 'email' =>  'josetovarg@gmail.com');
        $profesor[11] = array('nombre' =>  'Giovanni','apellido' =>  'Coiro', 'email' =>  'idv.grafico@gmail.com');
        $profesor[12] = array('nombre' =>  'Aleidy','apellido' =>  'Dorante', 'email' =>  'aleidydorante_17@hotmail.com');
        $profesor[13] = array('nombre' =>  'Cesar','apellido' =>  'Angulo', 'email' =>  'lcanguloguerrero@gmail.com');
        $profesor[14] = array('nombre' =>  'Claudia','apellido' =>  'Paez', 'email' =>  'claudiapp18@gmail.com');
        $profesor[15] = array('nombre' =>  'Miguel','apellido' =>  'Tellechea', 'email' =>  'miguel.tellechea@gmail.com');
        $profesor[16] = array('nombre' =>  'irene','apellido' =>  'Mendez', 'email' =>  'irenemendezidv@gmail.com');
        $profesor[17] = array('nombre' =>  'Jesus','apellido' =>  'Roso', 'email' =>  'jesusroso18487@gmail.com');
        $profesor[18] = array('nombre' =>  'Leonora','apellido' =>  'Armas', 'email' =>  'idvleonora69@gmail.com');
        $profesor[19] = array('nombre' =>  'Maizun','apellido' =>  'Rachid', 'email' =>  'maizun2003@gmail.com');
        $profesor[20] = array('nombre' =>  'Maria Alejandra','apellido' =>  'Quijada', 'email' =>  'marialeqidv@gmail.com');
        $profesor[21] = array('nombre' =>  'Miguel','apellido' =>  'Fernandez', 'email' =>  'miguelferromero@gmail.com');
        $profesor[22] = array('nombre' =>  'Nicolas','apellido' =>  'Riveros Tejada', 'email' =>  'rivanders@yahoo.com');
        $profesor[23] = array('nombre' =>  'Valeria','apellido' =>  'Carabano', 'email' =>  'valeriacarabano@gmail.com');
        $profesor[24] = array('nombre' =>  'Zulay','apellido' =>  'Barrios', 'email' =>  'zuuumbatee@gmail.com');

        foreach ($profesor as $p) {
               

            
                $data = array(  'email' => $p['email'],
                              'email_verified_at' => now(),
                            'password' => '$2y$10$.NmSbP1C8bUCFmPChe52tewQFIDHRTy8Z31Wz5l/V0wIm4qfAUyW6', // 123456789
                              'remember_token' => Str::random(10));
                $user = User::create($data); 
                $user->assignRole("profesor");
                                

                  $perfil = DB::table('perfil')->insertGetId(
                      ['id_user' => $user->id,'nombre' => $p["nombre"], 'apellido'=> $p['apellido'],'fecha_nacimiento' => '1900-01-01', 'direccion' => "direccion"]);
                  
                  $profe = DB::table('profesor')->insertGetId(
                      ['id_user' => $user->id,'curriculum' => 'curriculum', 'fecha_inicio' =>now()]);
               
               
                
        }
        
    }
}

