<?php

use Illuminate\Database\Seeder;

class IlustracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carrera['4']['Editor de Imágenes II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor de Imágenes II','carrera' =>4,'semestre' =>3,'profesor' =>10);
        
        $carrera['4']['Dibujo Libre III'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Libre III','carrera' =>4,'semestre' =>3,'profesor' =>19);
        
        $carrera['4']['Ilustración I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Ilustración I','carrera' =>4,'semestre' =>3,'profesor' =>2);
        
        $carrera['4']['Editor Vectorial II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor Vectorial II','carrera' =>4,'semestre' =>3,'profesor' =>10);
        
        $carrera['4']['Psicología de la Percepción'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Psicología de la Percepción','carrera' =>4,'semestre' =>3,'profesor' =>0);
        
        $carrera['4']['Fotografía I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Fotografía I','carrera' =>4,'semestre' =>3,'profesor' =>16);
        
        $carrera['4']['3er Técnicas de Ilustración'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => '3er Técnicas de Ilustración','carrera' =>4,'semestre' =>3,'profesor' =>12);
        
        $carrera['4']['Dibujo Analítico I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Analítico I','carrera' =>4,'semestre' =>3,'profesor' =>1);
        
        $carrera['4']['Composición I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Composición I','carrera' =>4,'semestre' =>3,'profesor' =>21);
        
        //$carrera['4']['Editor Vectorial II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor Vectorial II','carrera' =>4,'semestre' =>3,'profesor' =>0);


        $idPensum = 4;
        $mat = 1;
        $period =  DB::table('periodo')->where('status', 'activo')->value('id');
        foreach ($carrera as $matter => $op) {
               
                foreach ($op as $key => $value) {

                    $idMatter = DB::table('materia')->insertGetId(
                    [
                        'nombre' =>  $key,
                        'descripcion' => $value['description'], 
                        'semestre'  =>$value['semestre'], 
                        'h_teorica' => $value['h_theory'], 
                        'h_practica' => $value['h_practice'],
                        'codigo' => "ilustr-".$mat
                    ]);

                    $idPensumHasMatter = DB::table('carrera_tiene_materia')->insert(
                    [
                        'id_carrera' => $idPensum,
                        'id_materia' => $idMatter
                    ]);
                    
                    $idPrograma = DB::table('programa')->insertGetId(
                            [
                                'id_materia'   => $idMatter, 
                                'id_periodo'   => $period
                            ]);
                    if ($value['profesor'] !=0) {
                        $clase = DB::table('clase_profesor_materia')->insertGetId(
                                    ['turno' => 'no aplica', 
                                    'id_materia' => $idMatter,
                                     'id_programa' => $idPrograma,
                                     'id_profesor' => $value['profesor']]
                            );
                    }
                    
                    $mat = $mat + 1;

                }

       }


    }
}
