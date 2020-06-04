<?php
use App\User; 
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserTeacherSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users_name = ['Adriany Soler',
                        'Cesar Angulo',
                        'Claudia Paez',
                        'Génesis Hernández',
                        'Igone Torrentgeneros',
                        'Irene Mendez',
                        'Jesús Roso',
                        'José Tovar',
                        'Juliet Millan',
                        'Leonora Armas',
                        'Maizun Rachid',
                        'Marcos Duarte',
                        'Valentina Giordano',
                        'Miguel Fernández',
                        'Mileidy motta',
                        'Nelson Sierra',
                        'Nicolás Rivero',
                        'Patricia Vargas',
                        'Valeria Carabaño',
                        'Zulay Barrios',
                        'Giuseppe Román',
                        'Sofia Olaizola',
                        'María Andreina Pacheco',
                        'Kevin Loaiza',
                        'María Alejandra Quijada',
                        'Giovanni Coiro'];
        $teacher = 1;                
        foreach ($users_name as $name ) {
           $email = "teacher".$teacher."@disegnovalencia.com";
            $id = DB::table('users')->insertGetId(
                ['name' => $name, 
                'email' => $email,
                'email_verified_at' => now(),
                'password' => '$2y$10$v0gb8RrOMWIwziF80vsV5.fWaHCVAjOJfDethguZKNL8SY7VxNs5m',
                'remember_token' => Str::random(10)]);
           
           
            DB::table('person')->insert([
                ['id_user' => $id, 
                'name' => $name,
                'birthday' => now(),
                'address' => 'Carabobo - Venezuela']
            ]);

            DB::table('teacher')->insert([
                ['id_user' => $id, 
                'start_date' => now(),
                'end_date' => now(),
                'curriculum' => 'Profesor de diseño']
            ]);

            $user = User::find($id);
            $user->assignRole('teacher');
            $teacher++;
        
        }
    }
}
