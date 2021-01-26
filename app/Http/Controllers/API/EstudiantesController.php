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
    public function index($periodo = NULL)
    {
        if (!$periodo) 
        {
          $periodo =  DB::table('periodo')->where('status', 'activo')->value('id');
        }

        $results = DB::select("SELECT p.`nombre`, `apellido`, p.`imagen`, `semestre` , c.`nombre` as `especialidad` FROM `inscripcion` as i, `estudiante` as e, `perfil` as p, `grupo` as g, `carrera` as c WHERE i.`id_estudiante` = e.`id` AND e.`id_user` = p.`id_user` AND g.`id` = i.`id_grupo` AND g.`id_carrera` = c.`id` AND i.`id_periodo` = ?",[$periodo]);
        
        return ($results);       
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
                      'cedula' =>'required|numeric', 
                      'fecha_nacimiento' =>'required|date', 
                      'genero' => 'required', 
                      'direccion' => 'required', 
                      'email' => 'required|email', 
                      'password' => 'required', 
                      'password_confirmation' => 'required|same:password'
                    ]);

                    if ($validator->fails()) 
                    { 
                       return self::respuestaError(204, $validator->errors());
                       // return response()->json([ 'error'=> $validator->errors() ]);
                    }
                    return $this->nuevo($request->all());
                break;
            case 'regular':
              # code...
              break;
                case 'cuotas':
                   $validator = Validator::make($request->all(), [ 
                      'id_student' => 'required', 
                      'amount' => 'required', 
                      'description' => 'required'
                    ]);

                    if ($validator->fails()) 
                    { 
                     // return response()->json([ 'error'=> $validator->errors() ]);
                      return self::respuestaError(204, $validator->errors());
                    }
                    return $this->cuotas($request->all());
                break;

            
            default:
                # code...
                break;
        }
    }
    public function nuevo($data,$grupo = NULL)
    {
            $period =  DB::table('periodo')->where('status', 'activo')->value('id');
            
            if(empty($period))
            {
              return self::respuestaError(400, "Periodo no ha iniciado");
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
                             'fecha_nacimiento' =>$data["fecha_nacimiento"],
                             'genero' => $data['genero'],
                             'cedula' =>$data['cedula'],
                             'direccion' =>$data['direccion'] ]);
            
            $student =  DB::table('estudiante')->insertGetId(
                            ['id_user' => $user->id, 
                             'curriculum' =>"curriculum",
                             'fecha_inicio' =>now() ]);

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

            if (!$grupo) 
            {
              $results = DB::select("SELECT `id` FROM `grupo` WHERE `id_carrera` = 1 AND `id_periodo` = ?",[$period]);
              $min = 999999999;
              foreach ($results as $result => $value) 
              {
                  $users = DB::table('inscripcion')->where('id_grupo', $value->{'id'})->count();
                  if ($min > $users) {
                    $grupo = $value->{'id'};
                    $min = $users;
                  }
                 
              }
            }

            $inscription = DB::table('inscripcion')->insertGetId([
                                        'id_estudiante' => $student, 
                                        'id_periodo' =>$period,
                                        'id_pagos' =>$payment,
                                        'status' =>"pendiente",
                                        'id_grupo' =>$grupo,
                                        'semestre' =>1
            ]);
           

            if (!empty($person) and !empty($student) and !empty($inscription)) {
                $dato["results"]['id'] = $user->id;
                return response()->json(['status' => "success", "data" =>$dato ]);
            }
            else{
                return self::respuestaError(400,  "El estudiante no pudo ser inscrito");
                //return response()->json(['status' => 'error', 'data'=> "El estudiante no pudo ser inscrito"]);
            }
        
    }
    public function cuotas($data)
    {
        $period  = DB::table('periodo')->where('status', 'activo')->value('id');
    
        if(empty($period))
        {
           return self::respuestaError(400, "Periodo no ha iniciado");
            //return response()->json([  'status' => 'error', 'data'=> "Periodo no ha iniciado"  ]);
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
           return self::respuestaError(400,  "Pago no guardado");
          //  return response()->json(['status' => 'error', 'data'=> "Pago no guardado"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //estudiantes/{qty?}/{contenido?}/{id?}
    public function MostrarEstudiante($id){
       
        $user = User::find($id);

                  if (!empty($user)) {
                     $tipo = $user->getRoleNames();
                  }
                 
                  
                    if(!empty($tipo) AND $tipo[0] == "estudiante"){

                      $student['results'] = DB::select("SELECT * FROM `inscripcion` as i,`users` as u, `perfil` as p, `estudiante` as e WHERE e.`id` = i.`id_estudiante` AND e.`id_user` = u.`id` AND p.`id_user` = e.`id_user` AND u.`id` = ?", [$id]);

                       return response()->json([ 'status' => "success", 'data'=> $student]);
                    }
                    else{
                      if(empty(!$user)){
                         //return response()->json(['status' => 'error', 'data' => "No es estudiante"]);
                         return self::respuestaError(204, "El ID ".$id." no pertence a un estudiante");
                      }
                     
                    }
    }
    public function MostrarEstudiantes($period = NULL){
      if (empty($period)) {
            $period  = DB::table('periodo')->where('status', 'activo')->value('id');
      }                   
      $results['results'] = DB::select("SELECT p.`nombre`,u.`email`,u.`id`,i.`id_estudiante`,i.`id_periodo`,i.`status` FROM `inscripcion` as i, `estudiante` as s, `users` as u,  `perfil` as p WHERE s.`id_user` = u.`id` AND i.`id_estudiante` = s.`id` AND  p.`id_user` = u.`id`AND i.`id_periodo` = ?", [$period]);
      if (!empty( $results['results'])) {
         return response()->json(['status' => "success", "data" => $results]);
      }
      //return response()->json(['status' => 'error', 'data' => "No hay estudiantes inscritos"]);  
      return self::respuestaError(204, "No hay estudiantes inscritos");  

    } 
    public function MostrarEstudiantesAdmin($periodo = NULL){
        $user = Auth::user(); 
        if (!$periodo) 
        {
          $periodo =  DB::table('periodo')->where('status', 'activo')->value('id');
        }

        $results['data'] = DB::select("SELECT p.`nombre`, `apellido`, `telefono`,`celular`, p.`imagen`, `semestre` , c.`nombre` as `especialidad` FROM `inscripcion` as i, `estudiante` as e, `perfil` as p, `grupo` as g, `carrera` as c WHERE i.`id_estudiante` = e.`id` AND e.`id_user` = p.`id_user` AND g.`id` = i.`id_grupo` AND g.`id_carrera` = c.`id` AND i.`id_periodo` = ?",[$periodo]);
        if ($results['data']) {
          return response()->json([ 'status' => "success", 'data'=> $results['data']]);
        }
    }   
    public function show($id, $cont = "info", $period = NULL)
    {
    
        switch ($cont) {
            case 'info':
                if(is_numeric($id)){
                  $user = User::find($id);

                  if (!empty($user)) {
                     $tipo = $user->getRoleNames();
                  }
                 
                  //;
                    if(!empty($tipo) AND $tipo[0] == "estudiante"){
                      $student['results'] = DB::select("SELECT * FROM `inscripcion` as i,`users` as u, `perfil` as p, `estudiante` as e WHERE e.`id` = i.`id_estudiante` AND e.`id_user` = u.`id` AND p.`id_user` = e.`id_user` AND u.`id` = ?", [$id]);

                    }
                    else{
                      if(empty(!$user)){
                         //return response()->json(['status' => 'error', 'data' => "No es estudiante"]);
                         return self::respuestaError(204, "El ID ".$id." no pertence a un estudiante");
                      }
                     
                    }
                   
                    
                }
                else
                {
                    $student = DB::select("SELECT * FROM `inscripcion` as i,`users` as u, `perfil` as p, `estudiante` as e  WHERE e.`id_user` = i.`id_estudiante` AND e.`id_user` = u.`id` AND p.`id_user` = e.`id_user` AND u.`email` = ?", [$id]);
                }
                if (!empty($student['results'])) {
                    return response()->json([ 'status' => "success", 'data'=> $student]);
                }
                //return response()->json(['status' => 'error', 'data' => "No existe el estudiante"]);
                return self::respuestaError(204, "El ID ".$id."no existe");
                      break;
            case 'inscritos':
                    if (empty($period)) {
                       $period  = DB::table('periodo')->where('status', 'activo')->value('id');
                    }
                    

                    $results['results'] = DB::select("SELECT p.`nombre`,u.`email`,u.`id`,i.`id_estudiante`,i.`id_periodo`,i.`status` FROM `inscripcion` as i, `estudiante` as s, `users` as u,  `perfil` as p WHERE s.`id_user` = u.`id` AND i.`id_estudiante` = s.`id` AND  p.`id_user` = u.`id`AND i.`id_periodo` = ?", [$period]);
                    if (!empty( $results['results'])) {
                      return response()->json(['status' => "success", "data" => $results]);
                    }
                    //return response()->json(['status' => 'error', 'data' => "No hay estudiantes inscritos"]);  
                    return self::respuestaError(204, "No hay estudiantes inscritos");    
                      break;
            case 'materia':
                    $periodo =  DB::table('periodo')->where('status', 'activo')->value('id');
                    $id_materia = $period;
                    $estudiantes['results'] = DB::select("SELECT `id_estudiante` as `id` , per.`nombre`,per.`apellido`,`imagen`  FROM `inscripcion` as i, `programa` as p, `materia` as m, `estudiante` as e, `perfil` as per, `users` as u WHERE m.`id` = ? AND p.`id_periodo` = i.`id_periodo` AND p.`id_periodo` = ? AND m.`id` = p.`id_materia` AND i.`id_grupo` = p.`id_grupo` AND e.`id` = i.`id_estudiante` AND e.`id_user` = u.`id` AND e.`id_user` = per.`id_user` LIMIT ?",[$id_materia,$periodo,$id]);
                     
                    if (!empty($estudiantes['results'])) {
                      return response()->json([ 'status' => "success", 'data'=>$estudiantes]);
                    }
                      //return response()->json([ 'status' =>'error', 'data' =>$estudiantes]); 
                       return self::respuestaError(204, "No hay estudiantes inscritos");  

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
    public function add(){

     /*$arrayEstudiantes[0] = array('nombre'=>'Aida', 'apellido' => 'Vidal'  , 'email' => 'admon.idv.valencia@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[1] = array('nombre'=>'ANGEL DIOMAR' ,'apellido' => 'BARRIOS SANGRONIS', 'email' => 'diomaresang@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[2] = array('nombre'=>'YESICA', 'apellido' => 'CHEUNG FAN', 'email' => 'yesicacheung@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[3] = array('nombre'=>'Claudys','apellido' =>  'Del Castillo'  , 'email' => 'claudysdelcastillop@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[4] = array('nombre'=>'SALMA','apellido' =>  'EL HAGE' , 'email' => 'salmaelhage123@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[5] = array('nombre'=>'MENGSHI','apellido' => 'FANG', 'email' => 'zonabcindyf@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[6] = array('nombre'=>'MAHMUD TOBIA','apellido' =>  'SAFILLI CRISTINA' , 'email' => 'safimahmudtobia@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[7] = array('nombre'=>'Angela Maria', 'apellido' => 'Medina Prieto'  , 'email' => 'angelamariamedinaprieto@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[8] = array('nombre'=>'Jessica','apellido' =>  'Desirée', 'Medina Regnault', 'email' =>  'jessicadmedinar@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[8] = array('nombre'=>'Melissa', 'apellido' => 'Alzuro Amaro'  ,'email' =>  'mdvaa2302@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[9] = array('nombre'=>'MARIA SOFIA'  ,'apellido' => 'MENESES AMAYA','email' => 'maso0263@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[10] = array('nombre'=>'MARIA DE LOS ANGELES','apellido' =>  'MORALES MAVAREZ' , 'email' => 'mav10angeles@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[11] = array('nombre'=>'VICTORIA VALENTINA', 'apellido' => 'MORALES VALERA','email' =>  'victoriavalen372@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[12] = array('nombre'=>'Maria Fernanda','apellido' =>  'Moreno'  , 'email' => 'maria.fm1708@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[13] = array('nombre'=>'Jennifer', 'apellido' => 'Osorio'  , 'email' => 'osoriolopez148@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[14] = array('nombre'=>'Maria','apellido' => 'Palencia'  , 'email' => 'mjpschlaepfer@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[15] = array('nombre'=>'JACKLING HENEYS','apellido' => 'SANCHEZ QUINTERO',  'email' => 'jhsq12@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789');

      $arrayEstudiantes[16] = array('nombre'=>'MARIANA CAROLINA', 'apellido' => 'VELASQUEZ DIAZ', 'email' => 'mcvd.20@gmail.c.com', 'password' =>'123456789', 'password_confirmation' => '123456789'); */
      $i = 9;
      foreach ( $arrayEstudiantes as $value) {
        if ($i<8) {
         $this->nuevo( $value,1);
        }
        else
        {
          $this->nuevo( $value,7);
        }
        $i++;
      }

      //return $this->nuevo($arrayEstudiantes);
      echo "listo";
    }
}
