<?php

use Illuminate\Database\Seeder;

class PensumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $carrera =     ["Diseño Grafico", "Diseño de Modas", "Ilustración","Diseño Industrial", "Diseño de interiores"];
         foreach ($carrera as $key ) {
         	$id = DB::table('pensum')->insertGetId(
                ['name' => $name, 
                'email' => $email,
                'email_verified_at' => now(),
                'password' => '$2y$10$v0gb8RrOMWIwziF80vsV5.fWaHCVAjOJfDethguZKNL8SY7VxNs5m',
                'remember_token' => Str::random(10)]);
         }
    }
}

