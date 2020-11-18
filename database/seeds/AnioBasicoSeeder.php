<?php

use Illuminate\Database\Seeder;

class AnioBasicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $carrera['1']['Color I'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Año Básico 1 Color I','carrera' =>1,'semestre' =>1,'profesor' =>21);
        $carrera['1']['Ciencias de la Visión I'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Ciencias de la Visión I','carrera' =>1,'semestre' =>1,'profesor' =>3);
        $carrera['1']['Ciencias de la Visión II'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Ciencias de la Visión II','carrera' =>1,'semestre' =>2,'profesor' =>12);
        $carrera['1']['Color II'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Color II','carrera' =>1,'semestre' =>2,'profesor' =>2);
        $carrera['1']['Dibujo libre I '] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo libre I ','carrera' =>1,'semestre' =>1,'profesor' =>12);


        $carrera['1']['Dibujo libre II'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo libre II','carrera' =>1,'semestre' =>2,'profesor' =>12);
        $carrera['1']['Dibujo Técnico II y Descriptiva II'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Técnico II y Descriptiva II','carrera' =>1,'semestre' =>2,'profesor' =>6);
        $carrera['1']['Dibujo Técnico y Descriptiva'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Técnico y Descriptiva','carrera' =>1,'semestre' =>1,'profesor' =>22);
        $carrera['1']['Dibujo y Levantamiento 3D'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo y Levantamiento 3D','carrera' =>1,'semestre' =>1,'profesor' =>11);
        $carrera['1']['Editor de Imagen I'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor de Imagen I','carrera' =>1,'semestre' =>2,'profesor' =>10);
        $carrera['1']['Editor Vectorial'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Editor Vectorial','carrera' =>1,'semestre' =>1,'profesor' =>17);
        $carrera['1']['Historia del Diseño'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Historia del Diseño','carrera' =>1,'semestre' =>2,'profesor' =>6);
        $carrera['1']['Taller I'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Taller I','carrera' =>1,'semestre' =>1,'profesor' =>14);
        $carrera['1']['Taller II'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Taller II','carrera' =>1,'semestre' =>2,'profesor' =>2);

        //agregar manual
        //$carrera['1']['Dibujo Libre I'] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo Libre I','carrera' =>1,'semestre' =>1,'profesor' =>19);
        //$carrera['1']['Dibujo libre II '] = array('description' => 'Año Básico', 'h_theory' =>1, 'h_practice' =>1, 'nombre' => 'Dibujo libre II ','carrera' =>1,'semestre' =>2,'profesor' =>19);
    

        $idPensum = 1;
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
                        'codigo' => "basico-".$mat
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
