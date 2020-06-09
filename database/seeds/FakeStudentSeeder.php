<?php

use App\User; 
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class FakeStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_name = ["Carlos Moreno", "Melanie Marval", "Rebeca Padron", "Yisus Villareal", "Amanda Attias"];
        $idSemestre = DB::table('semester')->insertGetId(
                [
                    'id_pensum' => 1,
                    'info1' => "relleno 1", 
                    'info2'  =>'relleno 2'
                ]);
        $idSection = DB::table('section')->insertGetId(
                [
                    'id_semester' => $idSemestre,
                    'alias' => "Seccion A", 
                    'description'  =>'Turno de la mañana'
                ]);

        $teacher = 1; 
        foreach ($users_name as $name ) {
            $email = "studet".$teacher."@disegnovalencia.com";
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

            DB::table('student')->insert([
                ['id_user' => $id, 
                  'id_section' => $idSection,
                'start_date' => now(),
                'end_date' => now(),
                'curriculum' => 'Alumno de diseño de modas']
            ]);

            $user = User::find($id);
            $user->assignRole('student');
            $teacher++;
        
        }
    }
}
