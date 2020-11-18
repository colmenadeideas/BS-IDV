<?php

use Illuminate\Database\Seeder;

class IndustrialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carrera['5']['Ergonomía I'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Ergonomía I','carrera' =>5,'semestre' =>3,'profesor' =>5);
        $carrera['5']['Taller III'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Taller III','carrera' =>5,'semestre' =>3,'profesor' =>22);
        $carrera['5']['Historia del Diseño'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Historia del Diseño','carrera' =>5,'semestre' =>3,'profesor' =>16);
        $carrera['5']['Dibujo y Levantamiento 2D II'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo y Levantamiento 2D II','carrera' =>5,'semestre' =>3,'profesor' =>22);
        $carrera['5']['Tecnología de los Materiales I'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Tecnología de los Materiales I','carrera' =>5,'semestre' =>3,'profesor' =>22);
        $carrera['5']['Diseño I'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño I','carrera' =>5,'semestre' =>3,'profesor' =>2);
        $carrera['5']['Rendering I'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Rendering I','carrera' =>5,'semestre' =>3,'profesor' =>1);
        $carrera['5']['Editor de Imagen II'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor de Imagen II','carrera' =>5,'semestre' =>3,'profesor' =>11);
        $carrera['5']['Industrial II'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Industrial II','carrera' =>5,'semestre' =>4,'profesor' =>14);
        $carrera['5']['Composición I'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Composición I','carrera' =>5,'semestre' =>4,'profesor' =>21);
        $carrera['5']['Ergonomía II'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Ergonomía II','carrera' =>5,'semestre' =>4,'profesor' =>5);
        $carrera['5']['Tecnología de los Materiales II'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Tecnología de los Materiales II','carrera' =>5,'semestre' =>4,'profesor' =>22);
        $carrera['5']['Rendering II'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Rendering II','carrera' =>5,'semestre' =>4,'profesor' =>0);
        $carrera['5']['Levantamiento y Animación 3D I'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Levantamiento y Animación 3D I','carrera' =>5,'semestre' =>4,'profesor' =>22);
        $carrera['5']['Taller IV'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Taller IV','carrera' =>5,'semestre' =>4,'profesor' =>22);
        $carrera['5']['Dibujo Analitico II'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Analitico II','carrera' =>5,'semestre' =>4,'profesor' =>8);
        $carrera['5']['Diseño Industrial IV'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño Industrial IV','carrera' =>5,'semestre' =>6,'profesor' =>3);
        $carrera['5']['Taller VI'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Taller VI','carrera' =>5,'semestre' =>6,'profesor' =>22);
        $carrera['5']['Portafolio'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Portafolio','carrera' =>5,'semestre' =>6,'profesor' =>6);
        $carrera['5']['Composición II'] = array('description' => 'Diseño Industrial', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Composición II','carrera' =>5,'semestre' =>4,'profesor' =>0);



        $idPensum = 5;
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
                        'codigo' => "Industrial-".$mat
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
