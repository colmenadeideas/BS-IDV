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
class EstudiantesController extends Controller
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
    public function store(Request $request, $tipo = "nuevo"){
        switch ($tipo) {
            case 'nuevo':
                $validator = Validator::make($request->all(), [ 
                      'nombre' => 'required', 
                      'apellido' => 'required', 
                      'email' => 'required|email', 
                      'password' => 'required', 
                      'password_confirmation' => 'required|same:password'
                    ]);

                    if ($validator->fails()) 
                    { 
                        return response()->json([ 'error'=> $validator->errors() ]);
                    }
                    return $this->nuevo($request->all());
                break;
                case 'cuotas':
                   $validator = Validator::make($request->all(), [ 
                      'id_student' => 'required', 
                      'amount' => 'required', 
                      'description' => 'required'
                    ]);

                    if ($validator->fails()) 
                    { 
                      return response()->json([ 'error'=> $validator->errors() ]);
                    }
                    return $this->cuotas($request->all());
                break;

            
            default:
                # code...
                break;
        }
    }
    public function nuevo($data)
    {
            $period =  DB::table('periodo')->where('status', 'activo')->value('id');
            
            if(empty($period))
            {
                return response()->json([ 'status' => 'error', 'data'=> "Periodo no ha iniciado" ]);
            }

            $data['role'] = 'estudiante'; 
            $data['password'] = Hash::make($data['password']);
            $role = $data['role'];
            $user = User::create($data); 
            $user->assignRole($role);
            
            $person =  DB::table('perfil')->insertGetId(
                            ['id_user' => $user->id, 
                             'nombre' =>$data["nombre"],
                             'apellido' =>$data["apellido"],
                             'fecha_nacimiento' =>"1990-08-26",
                             'direccion' =>'direccion' ]);
            
            $student =  DB::table('estudiante')->insertGetId(
                            ['id_user' => $user->id, 
                             'curriculum' =>"curriculum",
                             'fecha_inicio' =>"2020-08-26" ]);
            //pagos de carrera
            $results = DB::select("SELECT * FROM `costo` WHERE `semestre` = 1 AND `id_carrera` = 1");

            $payment = DB::table('pagos')->insertGetId([
                          'monto' => $results[0]->{'monto'}, 
                          'descripcion' =>"Monto a cancelar",
                          'status' =>"pendiente"]);
            DB::table('pagar_coutas')->insert([
                          'id_costo' => $results[0]->{'id'}, 
                          'id_pagos' => $payment, 
                          'id_carrera' =>1 ]);

            $inscription = DB::table('inscripcion')->insertGetId([
                                        'id_estudiante' => $student, 
                                        'id_periodo' =>$period,
                                        'id_pagos' =>$payment,
                                        'status' =>"pendiente",
                                        'semestre' =>1
            ]);
            if (!empty($person) and !empty($student) and !empty($inscription)) {
                return response()->json(['status' => "success"]);
            }
            else{
                return response()->json(['status' => 'error', 'data'=> "El estudiante no pudo ser inscrito"]);
            }
        
    }
    public function cuotas($data)
    {
        $period  = DB::table('periodo')->where('status', 'activo')->value('id');
    
        if(empty($period))
        {
            return response()->json([  'status' => 'error', 'data'=> "Periodo no ha iniciado"  ]);
        }
        
        $student = DB::select("SELECT * FROM `inscripcion` WHERE `id_estudiante` = ?", [$data['id_student']]);
        
        $dues = DB::table('cuotas')->insertGetId([
                                'id_pagos' => $student[0]->{'id_pagos'}, 
                                'monto' =>$data['amount'],
                                'status' =>"pendiente",
                                'descripcion' =>$data['description']
        ]);
        if(!empty($dues)){
            return response()->json(['status' => "success"]);
        }
        else{
            return response()->json(['status' => 'error', 'data'=> "Pago no guardado"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $cont = "info", $periodo = NULL)
    {
    
        switch ($cont) {
            case 'info':
                if(is_numeric($id)){
                   $student = DB::select("SELECT * FROM `inscripcion` as i,`users` as u, `perfil` as p, `estudiante` as e  WHERE e.`id_user` = i.`id_estudiante` AND e.`id_user` = u.`id` AND p.`id_user` = e.`id_user` AND i.`id_estudiante` = ?", [$id]);
                    
                }
                else
                {
                    $student = DB::select("SELECT * FROM `inscripcion` as i,`users` as u, `perfil` as p, `estudiante` as e  WHERE e.`id_user` = i.`id_estudiante` AND e.`id_user` = u.`id` AND p.`id_user` = e.`id_user` AND u.`email` = ?", [$id]);
                }
                if (!empty($student)) {
                    return response()->json([ 'status' => "success", 'data'=> $student]);
                }
                return response()->json(['status' => 'error', 'data' => "No existe el estudiante"]);
            break;
            case 'inscritos':
                    if (empty($period)) {
                       $period  = DB::table('periodo')->where('status', 'activo')->value('id');
                    }
                    else
                    {
                        $period  = DB::table('periodo')->where('codigo', $periodo)->value('id');
                    }

                    $results = DB::select("SELECT u.`nombre`,u.`email`,u.`id`,i.`id_estudiante`,i.`id_periodo`,i.`status` FROM `inscripcion` as i, `estudiante` as s, `users` as u WHERE s.`id_user` = u.`id` AND i.`id_estudiante` = s.`id` AND i.`id_periodo` = ?", [$period]);
                    if (!empty($results)) {
                      return response()->json(['status' => "success", "data" => $results]);
                    }
                    return response()->json(['status' => 'error', 'data' => "No hay estudiantes inscritos"]);
                    
                break;        
            default:
                # code...
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
