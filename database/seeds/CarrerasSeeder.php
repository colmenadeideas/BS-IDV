<?php

use Illuminate\Database\Seeder;

class CarrerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carrera = ["Año Basico","Diseño Grafico", "Diseño de Modas", "Ilustración","Diseño Industrial", "Diseño de interiores"];
        
         foreach ($carrera as $key ) {
         	$idC=DB::table('carrera')->insertGetId(
                ['fecha_inicio' => now(), 
                 'fecha_fin' => now(), 
                 'status' => 'activo',
                 'nombre' => $key,
                 'descripcion' => $key]);
         	
         	for ($i=1; $i <=6 ; $i++) {
         		$amount = floatval(120.2*$i);
         		DB::table('costo')->insert([
         		'monto' => $amount,
         		'semestre'  => $i,
         		'id_carrera' => $idC]);
         	}
       

         }
    }
}
