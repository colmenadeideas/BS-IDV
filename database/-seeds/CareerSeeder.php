<?php

use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
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
         	$idC=DB::table('career')->insertGetId(
                ['start_date' => now(), 
                 'end_date' => now(), 
                 'status' => 'active',
                 'name' => $key,
                 'description' => $key]);
         	
         	for ($i=1; $i <=6 ; $i++) {
         		$amount = floatval(120.2*$i);
         		DB::table('cost')->insert([
         		'amount' => $amount,
         		'semester'  => $i,
         		'id_career' => $idC]);
         	}
       

         }
    }
}
