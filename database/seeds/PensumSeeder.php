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
         	DB::table('pensum')->insert(
                ['start_date' => now(), 
                 'end_date' => now(), 
                 'status' => 'active',
                 'matters' => 'materias',
                'caree' => $key,
                'description' => $key]);
         }
    }
}

