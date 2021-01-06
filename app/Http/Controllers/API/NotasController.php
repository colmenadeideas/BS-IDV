<?php

namespace App\Http\Controllers\API;
use App\Nota; 
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class NotasController extends Controller
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
    public function show($tipo = NULL, $id)
    {
        $periodo =  DB::table('periodo')->where('status', 'activo')->value('id');
        switch ($tipo) {
            case 'estudiante':
              
                break;
            case 'materia':
                $data['results'] = DB::select("SELECT `id_estudiante` as `estudianteID`, n.`nota` as `value`, c.`id` as `claseID` FROM `programa` as pro, `clase_profesor_materia` as cpm, `clase` as c, `ensenar` as e, `evaluacion` as n, `inscripcion` as i WHERE pro.`id_materia` = ? AND pro.`id_periodo` = ? AND pro.`id` = cpm.`id_programa` AND cpm.`id` = c.`id_clase_profesor_materia` AND e.`id_clase` = c.`id` AND e.`id_evaluacion` = n.`id` AND i.`id` = e.`id_inscripcion` ",[$id,$periodo]);
                 if ($data['results']) {
                     return self::respuestaError(204, "No hay notas cargada para la materia");
                 }
                 return response()->json(['status' => "success", 'data' => $data['results']]);

                break; 
            case 'clase':
                $data['results'] = DB::select("SELECT `id_estudiante` as `estudianteID`, n.`nota` as `value` FROM `programa` as pro, `clase_profesor_materia` as cpm, `clase` as c, `ensenar` as e, `evaluacion` as n, `inscripcion` as i WHERE c.`id` = ? AND pro.`id_periodo` = ? AND pro.`id` = cpm.`id_programa` AND cpm.`id` = c.`id_clase_profesor_materia` AND e.`id_clase` = c.`id` AND e.`id_evaluacion` = n.`id` AND i.`id` = e.`id_inscripcion`",[$id,$periodo]);
                if ($data['results']) {
                     return self::respuestaError(204, "No hay notas cargada para la clase");
                 }
                 return response()->json(['status' => "success", 'data' => $data['results']]);
                break;           
            default:
              
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateID(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nota' => 'nullable|numeric',
            'nombre' => 'nullable|string',
            'tipo' => 'nullable|string',
            'porcentaje' => 'nullable|numeric'
        ]);
         if ($validator->fails()) { 
              //return response()->json([ 'error'=> $validator->errors() ]);
              return self::respuestaError(204, $validator->errors());
        }
        
        
        foreach ($input as $key => $value) 
        {
            if(empty($value)){
                unset($input[$key]);
            }
        }
       $nota = Nota::find($id);
       $value = $nota->update($input);
       $data['results'] = $input;
       
       if ($value == 1) {
            return response()->json(['status' => "success", 'data' => $data]);  
       }
       return response()->json(['status' => "error", 'data' => $data]);
    }

    public function update(Request $request, $claseID,$estudianteID)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nota' => 'required|numeric',
        ]);
        if ($validator->fails()) { 
              //return response()->json([ 'error'=> $validator->errors() ]);
              return self::respuestaError(400, $validator->errors());
        }
        $id_inscripcion = DB::table('inscripcion')->where('id_estudiante', $estudianteID)->value('id');

        $evaluacion = DB::select("SELECT `id_evaluacion`  FROM `ensenar` WHERE `id_inscripcion` = ? AND `id_clase` = ?",[ $id_inscripcion,$claseID]);
         
        $nota = Nota::find($evaluacion[0]->{'id_evaluacion'});
        $value = $nota->update($input);
               
       if ($value == 1) {
            return response()->json(['status' => "success"]);  
       }
       return self::respuestaError(400, "No se pudo actualizar la nota");
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
