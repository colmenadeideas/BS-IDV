<?php

namespace App\Http\Controllers\API;

use App\User; 
use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use DB;

class PerfilController extends Controller
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
    public function show($id, $from = NULL)
    {
        
        $user = User::find($id);
        $tipo = $user->getRoleNames();
        $periodo  = DB::table('periodo')->where('status', 'activo')->value('id');
        switch ($tipo[0]) {
            case 'estudiante':
                    $data['perfil'] = DB::select("SELECT * FROM `perfil` as p, `estudiante` as o WHERE p.`id_user` = o.`id_user` AND p.`id_user` = ?", [$id]);
                    $id_estudiante = DB::table('estudiante')->where('id_user', $id)->value('id');
                    $c = DB::select("SELECT `nombre`, i.`status` as `status` FROM `inscripcion` as i, `pagar_coutas` as pc, `carrera` as c WHERE i.`id_pagos` = pc.`id_pagos` AND c.`id` = pc.`id_carrera` AND i.`id_periodo` = ? AND i.`id_estudiante` = ?",[$periodo,$id_estudiante]);
                    if (empty($c)) {
                        $c = DB::select("SELECT `nombre`, i.`status` as `status` FROM `inscripcion` as i, `pagar_coutas` as pc, `carrera` as c WHERE i.`id_pagos` = pc.`id_pagos` AND c.`id` = pc.`id_carrera` AND i.`id_estudiante` = ? ORDER BY i.`id` DESC", [$id_estudiante]);
                    }
                         $data['carrera'] =  $c[0]->{'nombre'};             
                         $data['status pago'] =  $c[0]->{'status'};                         
                break;
            case 'profesor':
                    $data['perfil'] = DB::select("SELECT * FROM `perfil` as p, `profesor` as o WHERE p.`id_user` = o.`id_user` AND p.`id_user` = ?", [$id]);
                    
                    $id_profesor = DB::table('profesor')->where('id_user', $id)->value('id');

                    $data['materias'] = DB::select("SELECT m.`nombre`, `semestre`, `turno`,car.`nombre` as `materia` FROM  `carrera_tiene_materia` as ctm, `carrera` as car ,`materia` as m,  `clase_profesor_materia` as cm, `programa` as p WHERE m.`id` =  cm.`id_materia` AND cm.`id_profesor` = ? AND p.`id_periodo` = ? AND p.`id_materia` = m.`id` AND ctm.`id_carrera` = car.`id` AND ctm.`id_materia` = cm.`id_materia`", [$id_profesor, $periodo]);
                    if (empty($data['materias'])) {
                        $data['materias'] = DB::select("SELECT m.`nombre`, `semestre`, `turno`,car.`nombre` as `materia`, p.`codigo` FROM  `carrera_tiene_materia` as ctm, `carrera` as car ,`materia` as m,  `clase_profesor_materia` as cm, `programa` as p WHERE m.`id` =  cm.`id_materia` AND cm.`id_profesor` = ? AND p.`id_materia` = m.`id` AND ctm.`id_carrera` = car.`id` AND ctm.`id_materia` = cm.`id_materia`", [$id_profesor]);
                    }
                break;
            default:
                # code...
                break;
        }

        if (empty($from)) {
            return response()->json(['status' => "success", 'data' => $data]);
        }
        return $data;
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
