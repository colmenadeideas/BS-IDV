<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class MateriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($codigo = NULL)
    {

        if (empty($codigo)) {
           
           $results = DB::select("SELECT `m`.`id`, `m`.`nombre`,`c`.`nombre` as `especialidad`, `m`.`slug`, `dias` as `horario` FROM `carrera_tiene_materia` as `ctn` ,`carrera` as `c`, `materia` as `m`, `clase_profesor_materia` as `cpm`, `programa` as `p` WHERE `ctn`.`id_carrera` = `c`.`id` AND `m`.`status` = 'activo' AND `ctn`.`id_materia` = `m`.`id` AND `m`.`id` = `cpm`.`id_materia` AND `cpm`.`id_programa` =`p`.`id`");
           

           foreach ($results as $res) {
              $id = $res->{'id'};
              if ( $res->{'horario'} != NULL) {
                  
                  $res->{'horario'} =DB::select("SELECT pro.`id`,pro.`id_materia`,`dias` as `horario` FROM `programa` as `pro`, `periodo` as `per` WHERE per.`status` = 'activo' AND per.`id` = pro.`id_periodo` AND pro.`id_materia`= ?",[ $res->{'id'}]);

              }
              
              $data['results'][$id] = json_decode(json_encode($res),true);

              $data['results'][$id]['profesores'] = DB::select("SELECT `per`.`nombre`,`apellido`,`fecha_nacimiento`,`direccion`,`curriculum`,`fecha_inicio`,`fecha_fin`,`tipo` FROM `clase_profesor_materia` as `cpm`, `materia` as `m`, `profesor` as `p`, `perfil` as `per` WHERE `m`.`id` = ? AND`m`.`id` = `cpm`.`id_materia` AND `p`.`id` = `cpm`.`id_profesor` AND `p`.`id_user` = `per`.`id_user` AND `m`.`status` = 'activo'",[ $id]);
              
            
           }

        }
        else
        {
            
            $data['results'] =json_decode(json_encode( DB::select("SELECT DISTINCT `m`.`id`, `m`.`nombre`,`c`.`nombre` as `especialidad`,`m`.`slug` ,`dias` as `horario` FROM `carrera_tiene_materia` as `ctn` ,`carrera` as `c`, `materia` as `m`, `clase_profesor_materia` as `cpm`, `programa` as `p` WHERE `ctn`.`id_carrera` = `c`.`id` AND `m`.`id` = ? AND `ctn`.`id_materia` = `m`.`id` AND `m`.`id` = `cpm`.`id_materia` AND `cpm`.`id_programa` =`p`.`id`",[$codigo])),true);
            
           
            if ($data['results'][0]['horario']) {
               $horario =DB::select("SELECT pro.`id`,`dias` as `horario` FROM `programa` as `pro`, `periodo` as `per` WHERE per.`status` = 'activo' AND per.`id` = pro.`id_periodo` AND pro.`id_materia`= ?",[$codigo]);
                       
                       
                        $datos['id'] = $data['results'][0]['id'];
                        $datos['nombre'] = $data['results'][0]['nombre'];
                        $datos['especialidad'] = $data['results'][0]['especialidad'];
                        $datos['slug'] = $data['results'][0]['slug'];
                
                 $i = 0;
                foreach ($horario as  $value) {
                     $datos['horario'][$i] = $value->{'horario'};
                     $i++;
                }
                
                unset($data['results']);
                $data['results'] =json_decode(json_encode( $datos ),true);

            }
           
          
           
        }
        
        if (empty($data['results'])){
            //return response()->json([ 'status' => 'error', 'data' => "No hay materias" ]); 
            return self::respuestaError(204, "No hay materias cargada");
        }     
            return response()->json(['status' => "success", 'data' => $data]);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
