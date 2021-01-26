<?php

namespace App\Http\Controllers\API;

use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
//use Illuminate\Support\Facades\Auth; 
//use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use DB;

class PeriodoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    CONST HTTP_OK = Response::HTTP_OK;
    CONST HTTP_CREATED = Response::HTTP_CREATED;
    CONST HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    public function store(Request $request)
    {
     
    
        $validator = Validator::make($request->all(), [ 
            "inicio"  => 'required|date',  
            "finalizacion" => 'required|date', 
            "semanas"=> 'required', 
            "carreras" => 'required'

        ]);
        if ($validator->fails()) { 
            return response()->json([ 'error'=> $validator->errors() ]);
        }

        $results = DB::select("SELECT * FROM `periodo` WHERE `status` = 'activo'");
        if(!empty($results)){
            DB::table('periodo')
                ->where('id', $results[0]->{'id'})
                ->update(['status' => 'inactivo']);
        }
        $data = $request->all(); 

        $id = DB::table('periodo')->insertGetId(
                        [
                         'fecha_inicio' =>$data["inicio"],
                         'fecha_fin' =>$data["finalizacion"],
                         'status' =>'activo',
                         'semanas' => $data['semanas'] ]);
        if (empty($id)) {
            return self::respuestaError(400, "Periodo no creado");
        }
        for ($i=1; $i <= 6; $i++) { 
            if (in_array($i, $data['carreras'])) {
               DB::table('carrera')
                ->where('id',  $i)
                ->update(['status' => 'activo','id_periodo' => $id]);
            }else
            {
                DB::table('carrera')
                ->where('id',  $i)
                ->update(['status' => 'inactivo']);
            }
            
        }
        
        
       return response()->json([ 'status' => "success", 'data'=> $data]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($codigo)
    {
        $results = DB::select("SELECT * FROM `periodo` WHERE `id` = ?", [$codigo]);
        if(empty($results)){
            return response()->json([ 'status' => 'error', 'data' =>'El periodo no existe']);
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
    public function update(Request $request, $codigo)
    {
        $results = DB::select("SELECT * FROM `periodo` WHERE `codigo` = ?", [$codigo]);
        if(empty($results)){
            return response()->json([ 'error'=> 'Codigo no existe']);
        }
        $validator = Validator::make($request->all(), [ 
          'start' => 'date', 
          'end' => 'date'
        ]);
        if ($validator->fails()) { 
            return response()->json([ 'error'=> $validator->errors() ]);
        }
        $data = $request->all(); 
        if (empty($data['code'])) {
            $data['code'] = $codigo;
        }
        $id = DB::table('periodo')->insertGetId(
                        ['codigo' => $data["code"], 
                         'fecha_inicio' =>$data["start"],
                         'fecha_fin' =>$data["end"],
                         'status' =>'activo' ]);
        $success["id"] = $id;
        $response =  self::HTTP_CREATED;
        
        return response()->json(['status' => "success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($codigo)
    {
        $results = DB::select("SELECT * FROM `periodo` WHERE `codigo` = ?", [$codigo]);
        if(empty($results)){
            return response()->json([ 'error'=> 'Codigo no existe']);
        }
        else
        {
            DB::table('periodo')
                ->where('codigo', $codigo)
                ->update(['status' => 'inactivo']);
            return response()->json(['status' => "success"]);
        }
        
    }
}
