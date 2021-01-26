<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CarreraController extends Controller
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
    public function show($id=NULL, $periodo = NULL)
    {
        if($id)
        {
            if(!$periodo)
            {
                $data['results']= DB::select(" SELECT m.`id` , m.`nombre` as `titulo` FROM `carrera_tiene_materia` as ctm, `materia` as m WHERE ctm.`id_carrera` = ? AND ctm.`id_materia` = m.`id`",[ $id]);
                if ($data['results']) {
                    return response()->json([ 'status' => "success", 'data'=> $data]);
                }
                return self::respuestaError(204, "No hay materias cargadas");
            }
            else
            {
                $data['results']= DB::select(" SELECT `id`, `nombre` as `titulo`FROM `carrera` WHERE `id_periodo` = ?",[ $id]);
                if ($data['results']) {
                    return response()->json([ 'status' => "success", 'data'=> $data]);
                }
                return self::respuestaError(204, "No hay carreras cargada");
            }
        }
        else
        {
            $data['results']= DB::select(" SELECT `id`, `nombre` as `titulo`, `id_periodo` FROM `carrera`");
            if ($data['results']) {
                return response()->json([ 'status' => "success", 'data'=> $data]);
            }
            return self::respuestaError(204, "No hay carreras cargada");
        }
        
    }
    public function showCarrera($id_carrera,$id_materia){
        $data['results']= DB::select("SELECT m.`id` as `materiaID`, m.`semestre` as `semestreID` FROM `carrera_tiene_materia` as ctm, `materia` as m, `carrera` as c WHERE ctm.`id_carrera` = ? AND ctm.`id_materia` = m.`id` AND c.`id` = ctm.`id_carrera` AND c.`id_periodo` = ? ORDER BY `semestreID` ASC",[ $id_carrera,$id_materia]);
                if ($data['results']) {
                    return response()->json([ 'status' => "success", 'data'=> $data]);
                }
                return self::respuestaError(204, "No hay materias cargadas");
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
