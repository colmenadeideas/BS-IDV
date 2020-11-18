<?php

use Illuminate\Database\Seeder;

class InterioresSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carrera['6']['Diseño I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño I','carrera' =>6,'semestre' =>3,'profesor' =>15);
        $carrera['6']['Maquetería I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Maquetería I','carrera' =>6,'semestre' =>3,'profesor' =>15);
        $carrera['6']['Editor de Imágenes II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor de Imágenes II','carrera' =>6,'semestre' =>3,'profesor' =>10);
        $carrera['6']['Ergonomía I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Ergonomía I','carrera' =>6,'semestre' =>3,'profesor' =>5);
        $carrera['6']['Dibujo Analítico I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Analítico I','carrera' =>6,'semestre' =>3,'profesor' =>19);
        $carrera['6']['Dibujo Arquitectonico y Perspectiva I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Arquitectonico y Perspectiva I','carrera' =>6,'semestre' =>3,'profesor' =>13);
        $carrera['6']['Levantamiento y Animación 3D I'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Levantamiento y Animación 3D I','carrera' =>6,'semestre' =>3,'profesor' =>6);
        $carrera['6']['Propiedad de los Materiales y Complementos Decorativos'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Propiedad de los Materiales y Complementos Decorativos','carrera' =>6,'semestre' =>3,'profesor' =>13);
        $carrera['6']['Maquetería II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Maquetería II','carrera' =>6,'semestre' =>4,'profesor' =>15);
        $carrera['6']['Dibujo arquitectónico y Perspectiva II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo arquitectónico y Perspectiva II','carrera' =>6,'semestre' =>4,'profesor' =>6);
        $carrera['6']['Editor Vectorial II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor Vectorial II','carrera' =>6,'semestre' =>4,'profesor' =>10);
        $carrera['6']['Dibujo Analítico II y Rendering'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Analítico II y Rendering','carrera' =>6,'semestre' =>4,'profesor' =>0);
        $carrera['6']['Levantamiento y animación 3D II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Levantamiento y animación 3D II','carrera' =>6,'semestre' =>4,'profesor' =>13);
        $carrera['6']['Diseño II'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño II','carrera' =>6,'semestre' =>4,'profesor' =>6);
        $carrera['6']['Estilos y corrientes Arquitectónicas'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Estilos y corrientes Arquitectónicas','carrera' =>6,'semestre' =>4,'profesor' =>13);
        $carrera['6']['Animación Interactiva'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Animación Interactiva','carrera' =>6,'semestre' =>5,'profesor' =>0);
        $carrera['6']['Diseño de Interiores III'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño de Interiores III','carrera' =>6,'semestre' =>5,'profesor' =>6);
        $carrera['6']['Instalaciones Electricas y Sanitarias'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Instalaciones Electricas y Sanitarias','carrera' =>6,'semestre' =>5,'profesor' =>16);
        $carrera['6']['Levantamiento y Animación 3D III'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Levantamiento y Animación 3D III','carrera' =>6,'semestre' =>5,'profesor' =>16);
        $carrera['6']['Paisajismo'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Paisajismo','carrera' =>6,'semestre' =>5,'profesor' =>13);
        $carrera['6']['Diseño IV'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño IV','carrera' =>6,'semestre' =>6,'profesor' =>6);
        $carrera['6']['Portafolio'] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Portafolio','carrera' =>6,'semestre' =>6,'profesor' =>6);
        $carrera['6']['Animación '] = array('description' => 'Ilustración', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Animación ','carrera' =>6,'semestre' =>6,'profesor' =>0);



        $idPensum = 6;
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
                        'codigo' => "interiores-".$mat
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
                    echo "listo ".$mat."<br>";
                }

       }


    }
}
