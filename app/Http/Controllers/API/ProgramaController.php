<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProgramaController extends Controller
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
      $validator = Validator::make($request->all(), [ 
          'id_materia'   => 'required'
        ]);
        if ($validator->fails()) { 
          return response()->json([ 'error'=> $validator->errors() ]);
        }
        $data = $request->all(); 
        $period =  DB::table('periodo')->where('status', 'activo')->value('id');
        if(!empty($period)){
            $id = DB::table('programa')->insertGetId(
                            [
                                'id_materia'   => $data["id_materia"], 
                                'id_periodo'   => $period,
                                'dias'         => json_decode($data["id_materia"])
                            ]);
            return response()->json(['status' => "success"]);
        }
        return response()->json([ 'error'=> "No se ha iniciado un semestre" ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
        if(empty($id)){
            $period =  DB::table('periodo')->where('status', 'activo')->value('id');
           
            if(empty($period)){
                return response()->json([ 'error'=> "No se ha iniciado un semestre" ]); 
            }
            $results = DB::select("SELECT * FROM `programa` WHERE `id_periodo` = ?",[$periodo]);
            if (empty($results)) {
                return response()->json([ 'error'=> "No hay programas actualmente" ]); 
            }
            return response()->json(['status' => "success", 'data' => $results]);
        }  

        $results = DB::select("SELECT * FROM `progrma` WHERE `id_materia` = ?",[$id]);
        if (empty($results)) {
            return response()->json([ 'error'=> "No hay programas actualmente" ]); 
        }
            return response()->json(['status' => "success", 'data' => $results]);
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
