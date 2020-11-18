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
              $data['results'][$id] = json_decode(json_encode($res),true);
              $data['results'][$id]['profesores'] = DB::select("SELECT `per`.`nombre`,`apellido`,`fecha_nacimiento`,`direccion`,`curriculum`,`fecha_inicio`,`fecha_fin`,`tipo` FROM `clase_profesor_materia` as `cpm`, `materia` as `m`, `profesor` as `p`, `perfil` as `per` WHERE `m`.`id` = ? AND`m`.`id` = `cpm`.`id_materia` AND `p`.`id` = `cpm`.`id_profesor` AND `p`.`id_user` = `per`.`id_user` AND `m`.`status` = 'activo'",[ $id]);
              
            
           }

        }
        else
        {
            
            $data['materias'][$codigo] =json_decode(json_encode( DB::select("SELECT DISTINCT `m`.`id`, `m`.`nombre`,`c`.`nombre` as `especialidad`,`m`.`slug` ,`dias` as `horario` FROM `carrera_tiene_materia` as `ctn` ,`carrera` as `c`, `materia` as `m`, `clase_profesor_materia` as `cpm`, `programa` as `p` WHERE `ctn`.`id_carrera` = `c`.`id` AND `m`.`id` = ? AND `ctn`.`id_materia` = `m`.`id` AND `m`.`id` = `cpm`.`id_materia` AND `cpm`.`id_programa` =`p`.`id`",[$codigo])),true); 
            
        }
        
        if (empty($data)){
            return response()->json([ 'status' => 'error', 'data' => "No hay materias" ]); 
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
