<?php

namespace App\Http\Controllers\API;

use App\User; 
use App\Conversacion; 
use App\Mensaje; 
use App\Perfil; 
use App\PertenceAConversacion; 
use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$tipo=NULL, $id_sender = NULLL, $id_receptor = NULL)
    {
       switch ($tipo) {
           case 'sender':
                
                $validator = Validator::make($request->all(), [ 
                     'content' => 'required', 
                ]);
                
                if ($validator->fails()) { 
                    return self::respuestaError(400, $validator->errors());
                    //return response()->json([ 'error'=> $validator->errors() ]);
                }
                
                $data['mensaje'] = $request->content;
                $data['id_user'] = $id_sender;
                $mensaje = Mensaje::create($data); 
                $conversacion = Conversacion::create(); 
                unset($data);
                $data['id_user'] = $id_sender;
                $data['id_conversacion'] = $conversacion->id; 
                $PertenceAConversacion = PertenceAConversacion::create($data);
                unset($data);
                $data['id_user'] = $id_receptor;
                $data['id_conversacion'] = $conversacion->id; 
                $PertenceAConversacion = PertenceAConversacion::create($data);
                unset($data);
                $data["results"]["senderID"] = $id_sender;
                $data["results"]["receiverID"] = $id_receptor;
                $data["results"]["content"] = $request->content;
                return response()->json([ 'status' => "success", 'data'=>$data]);

               break;
            
           default:
               # code...
               break;
       }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tipo=NULL, $id_sender = NULL, $id_receptor = NULL,$qty = NULL)
    {
        switch ($tipo) {
            case 'sender':
                $conversacion = DB::select("SELECT DISTINCT upc1. `id_conversacion` FROM `user_pertence_conversacion` as upc1 INNER JOIN `user_pertence_conversacion` as upc2 ON upc1.`id_user` = ? AND upc2.`id_user` =? AND upc1.`id_conversacion` = upc2.`id_conversacion`", [$id_sender,$id_receptor]);
                if (!$conversacion) {
                    return self::respuestaError(204, "No hay una conversacion entre ambos usuarios");
                }
                $conversacion = $conversacion[0]->{'id_conversacion'};
                
                $mensajes = DB::select("SELECT m.`id`,m.`id_user` as `senderID`, `mensaje`,m.`created_at` as `creation_date` FROM `mensaje` as m, `conversacion` as c WHERE c.`id`= ? AND m.`id_conversacion` = c.`id` LIMIT ?", [$conversacion,$qty]);
                $mensajes = json_decode( json_encode($mensajes), true);
                $i = 0;
                foreach ($mensajes as $mensaje) {
                    $aux['results'][$i] = $mensaje;
                    if($mensaje['senderID'] == $id_sender){
                       
                        $aux['results'][$i]['receiverID'] = $id_receptor;
                    }
                    else{
                         $aux['results'][$i]['receiverID'] =  $id_sender;
                         $aux['results'][$i]['senderID'] = $id_receptor;
                    }
                    $i++;
                }
                if (!$mensajes) {
                    return self::respuestaError(204, "No hay mensajes disponibles entre ambos usuarios");
                }
                return response()->json([ 'status' => "success", 'data'=>$aux]);
                
                
                break;
            case 'estudiantes':
                $estudiantes['results'] = DB::select("SELECT e.`id`,e.`id_user`,`nombre`, `apellido`, `imagen` FROM `estudiante` as e, `perfil` as p WHERE p.`id_user` = e.`id_user`");
                if (!$estudiantes['results']) {
                     return self::respuestaError(204, "No hay estudiantes disponibles");
                }
                return response()->json([ 'status' => "success", 'data'=> $estudiantes]);

                break;
            case 'profesores':
                $profesores['results'] = DB::select("SELECT e.`id`,e.`id_user`,`nombre`, `apellido`, `imagen` FROM `profesor` as e, `perfil` as p WHERE p.`id_user` = e.`id_user`");
                if (!$profesores['results']) {
                     return self::respuestaError(204, "No hay profesores disponibles");
                }
                return response()->json([ 'status' => "success", 'data'=> $profesores]);
                break;
            case 'user':
                $user = User::find($id_sender);
                if (!$user) {
                     return self::respuestaError(204, "No hay usuario con el ID ".$id_sender);
                }
                $rol  = $user->getRoleNames()[0];
                if ($rol == 'estudiante') {
                   $periodo =  DB::table('periodo')->where('status', 'activo')->value('id'); 
                   $info = DB::select("SELECT e.`id`,`nombre`, `apellido`, `imagen`, i.`semestre` FROM `estudiante` as e, `perfil` as p,  `inscripcion` as i WHERE p.`id_user` = e.`id_user` AND p.`id_user` = ? AND e.`id` = i.`id_estudiante` AND i.`id_periodo` = ?",[$id_sender,$periodo]);
                }
                else
                {
                    $info = DB::select("SELECT e.`id`,`nombre`, `apellido`, `imagen` FROM `profesor` as e, `perfil` as p WHERE p.`id_user` = e.`id_user` AND p.`id_user` = ?",[$id_sender]);
                }
                
                
                $info['results'] = json_decode( json_encode($info), true)[0];
                $info['results']['entidad'] = $rol;
                unset($info[0]);
                
                if ($rol == 'profesor') {
                    $id = $info['results']['id'];
                   
                $info['results']['materias'] = DB::select("SELECT m.`id`, m.`nombre`, `semestre`, m.`slug`, c.`nombre` as `especialidad`, m.`status` FROM `clase_profesor_materia` as `cpm`, `materia` as `m`, `carrera` as `c`, `carrera_tiene_materia` as `ctm` WHERE cpm.`id_profesor` = ? AND cpm.`id_materia` = m.`id` AND m.`id` = ctm.`id_materia` AND ctm.`id_carrera` = c.`id`", [ $id ]);
                }
                
                return response()->json([ 'status' => "success", 'data'=> $info]);
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
    public function destroy($id = NULL)
    {
      
    }

}
