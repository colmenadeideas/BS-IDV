<?php

use Illuminate\Database\Seeder;

class GraficoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carrera['2']['Técnicas de Presentación'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Técnicas de Presentación','carrera' =>2,'semestre' =>3,'profesor' =>21);
        $carrera['2']['Animación I'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Animación I','carrera' =>2,'semestre' =>5,'profesor' =>0);
        $carrera['2']['Animación II'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Animación II','carrera' =>2,'semestre' =>6,'profesor' =>2);
        $carrera['2']['Dibujo Analítico I'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Analítico I','carrera' =>2,'semestre' =>3,'profesor' =>19);
        $carrera['2']['Diseño  III'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño  III','carrera' =>2,'semestre' =>5,'profesor' =>21);
        $carrera['2']['Diseño II'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño II','carrera' =>2,'semestre' =>4,'profesor' =>11);
        $carrera['2']['Diseño IV'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Diseño IV','carrera' =>2,'semestre' =>6,'profesor' =>7);
        $carrera['2']['Editor de Imagen II'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor de Imagen II','carrera' =>2,'semestre' =>3,'profesor' =>11);
        $carrera['2']['Editor Vectorial II'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor Vectorial II','carrera' =>2,'semestre' =>4,'profesor' =>10);
        $carrera['2']['Editorial I'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editorial I','carrera' =>2,'semestre' =>4,'profesor' =>21);
        $carrera['2']['Editorial II'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editorial II','carrera' =>2,'semestre' =>5,'profesor' =>21);
        $carrera['2']['Empaque I'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Empaque I','carrera' =>2,'semestre' =>5,'profesor' =>7);
        $carrera['2']['Empaque II'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Empaque II','carrera' =>2,'semestre' =>6,'profesor' =>11);
        $carrera['2']['Fotografía I'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Fotografía I','carrera' =>2,'semestre' =>3,'profesor' =>16);
        $carrera['2']['Fotografía II'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Fotografía II','carrera' =>2,'semestre' =>4,'profesor' =>17);
        $carrera['2']['Gráfico I'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Gráfico I','carrera' =>2,'semestre' =>3,'profesor' =>12);
        $carrera['2']['Historia del Diseño'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Historia del Diseño','carrera' =>2,'semestre' =>4,'profesor' =>19);
        $carrera['2']['Lettering I'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Lettering I','carrera' =>2,'semestre' =>3,'profesor' =>19);
        $carrera['2']['Lettering II'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Lettering II','carrera' =>2,'semestre' =>4,'profesor' =>18);
        $carrera['2']['Lettering III'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Lettering III','carrera' =>2,'semestre' =>5,'profesor' =>11);
        $carrera['2']['Levantamiento y Animación 3D '] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Levantamiento y Animación 3D ','carrera' =>2,'semestre' =>5,'profesor' =>22);
        $carrera['2']['Portafolio'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Portafolio','carrera' =>2,'semestre' =>6,'profesor' =>6);
        $carrera['2']['Psicología de la Percepción'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Psicología de la Percepción','carrera' =>2,'semestre' =>3,'profesor' =>0);
        $carrera['2']['Taller de Dibujo'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Taller de Dibujo','carrera' =>2,'semestre' =>4,'profesor' =>19);
        $carrera['2']['Tecnología Gráfica'] = array('description' => 'Diseño Grafico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Tecnología Gráfica','carrera' =>2,'semestre' =>5,'profesor' =>7);

    

        $idPensum = 2;
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
                        'codigo' => "grafico-".$mat
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
