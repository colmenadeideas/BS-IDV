<?php

use Illuminate\Database\Seeder;

class MatterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Primer semestre
           //Primer semestre
        $matters["Basico"]["Taller I"] =  array( 'description' => 'Año Básico','semester' =>1, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Editor Vectorial"] =  array( 'description' => 'Año Básico','semester' =>1, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Ciencias de la Visión I"] =  array( 'description' => 'Año Básico','semester' =>1, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Dibujo y Levantamiento 3D"] =  array( 'description' => 'Año Básico','semester' =>1, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Semestre Dibujo Técnico y Descriptiva"] =  array( 'description' => 'Año Básico','semester' =>1, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Color I"] =  array( 'description' => 'Año Básico','semester' =>1, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Dibujo Libre I"] =  array( 'description' => 'Año Básico','semester' =>1, 'h_theory' =>1, 'h_practice' =>1 );
        // segundo semestre

        $matters["Basico"]["Dibujo Libre II"] =  array( 'description' => 'Año Básico','semester' =>2, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Dibujo Técnico II"] =  array( 'description' => 'Año Básico','semester' =>2, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Taller II"] =  array( 'description' => 'Año Básico','semester' =>2, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Color II"] =  array( 'description' => 'Año Básico','semester' =>2, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Basico"]["Ciencias de la Visión II"] =  array( 'description' => 'Año Básico','semester' =>2, 'h_theory' =>1, 'h_practice' =>1 );

        // Diseño de modas
        //Semestre 3
        $matters["Diseño de Modas"]["Fashion Illustration 1"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Diseño I"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Accesorios I"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Historia del Vestido"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Costuras Básicas y Textiles"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Corte y Patrones I"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Corte y Patrones II"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Editor de Imagen II"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Dibujo Analítico I"] =  array( 'description' => '3er semenestre','semester' =>3, 'h_theory' =>1, 'h_practice' =>1 );

        //Semestre 4

        $matters["Diseño de Modas"]["Fashion Illustration 2"] =  array( 'description' => '4to semenestre','semester' =>4, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Dibujo analítico 2"] =  array( 'description' => '4to semenestre','semester' =>4, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Diseño de Modas"] =  array( 'description' => '4to semenestre','semester' =>4, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Patronaje Industrial Escala I"] =  array( 'description' => '4to semenestre','semester' =>4, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Psicología de la Percepción"] =  array( 'description' => '4to semenestre','semester' =>4, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Orfebrería I"] =  array( 'description' => '4to semenestre','semester' =>4, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Editor Vectorial II"] =  array( 'description' => '4to semenestre','semester' =>4, 'h_theory' =>1, 'h_practice' =>1 );

        //Semestre 5
        $matters["Diseño de Modas"]["Fashion Illustration 3"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Accesorios II"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Diseño III"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Ilustración Digita"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Corte y Patrones IV"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Patronaje Industrial Escala II"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Corte y Patrones III"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Industria y Fabricación I"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Desfile y Logística I"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );

        //Semestre 6    
        $matters["Diseño de Modas"]["Desfile y Logística Industria y Fabricación II"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Diseño de Modas"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Portafolio"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Propiedad Intelectual"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        $matters["Diseño de Modas"]["Orfebrería II"] =  array( 'description' => '5to semenestre','semester' =>5, 'h_theory' =>1, 'h_practice' =>1 );
        
        $idPensum = DB::table('pensum')->insertGetId(
                [
                    'start_date' =>  now(),
                    'end_date' => now(), 
                    'status'  =>'active', 
                    'caree' => 'Diseño de modas', 
                    'matters' => 'Todas las materias',
                    'description' => 'pensum activo'
                ]);


        foreach ($matters as $matter => $op) {
               
                foreach ($op as $key => $value) {

                    $idMatter = DB::table('matter')->insertGetId(
                    [
                        'name' =>  $key,
                        'description' => $value['description'], 
                        'semester'  =>$value['semester'], 
                        'h_theory' => $value['h_theory'], 
                        'h_practice' => $value['h_practice']
                    ]);

                    $idPensumHasMatter = DB::table('pensum_has_matter')->insert(
                    [
                        'id_pensum' => $idPensum,
                        'id_matter' => $idMatter
                    ]);

                }
       }


    }


    
}

