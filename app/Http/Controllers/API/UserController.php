<?php

namespace App\Http\Controllers\API;

use App\User; 
use App\Perfil; 
use App\Estudiante; 
use App\Profesor; 
use Validator;
use Illuminate\Http\Request;  
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use DB;

class UserController extends Controller
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
    public function show($id = NULL)
    {
        

    	
        $user = User::find($id);
        if (!empty($user)) {
            $tipo = $user->getRoleNames();
        }
        else
        {
        	return self::respuestaError(204, "El usuario no existe");
        }

        switch ($tipo[0]) {
        	case 'estudiante':
        		$usuario['results']= DB::select("SELECT p.`nombre`, `apellido`,`email`, `fecha_nacimiento`, `direccion`, `imagen`, `curriculum`, `fecha_inicio`, `fecha_fin` FROM `users` as u, `perfil` as p, `estudiante` as pro WHERE u.`id` = ? AND u.`id` = p.`id_user` AND u.`id` = pro.`id_user`", [$id]);

        		break;
        	case 'profesor':
        		 $usuario['results']= DB::select("SELECT p.`nombre`, `apellido`,`email`, `fecha_nacimiento`, `direccion`, `imagen`, `curriculum`, `fecha_inicio`, `fecha_fin`, `status`, `tipo` FROM `users` as u, `perfil` as p, `profesor` as pro WHERE u.`id` = ? AND u.`id` = p.`id_user` AND u.`id` = pro.`id_user`", [$id]);
        		break;
        	default:
        		$usuario['results']= DB::select("SELECT p.`nombre`, `apellido`,`email`, `fecha_nacimiento`, `direccion`, `imagen` FROM `users` as u, `perfil` as p, `estudiante` as pro WHERE u.`id` = ? AND u.`id` = p.`id_user`", [$id]);
        		break;
        }
        if ($usuario['results']) {
        	 return response()->json([ 'status' => "success", 'data'=>$usuario]);
        }
       
        return self::respuestaError(204, "No se puedo encontrar información ");
      // return response()->json([ 'status' => "error", 'data'=>$usuario]);
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
        $input = $request->all();

        $validator = Validator::make($input, [
            'nombre' => 'nullable|string',
            'apellido' => 'nullable|string',
            'direccion' => 'nullable|string',
            'imagen' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'status' => 'nullable|string',
            'tipo' => 'nullable|string',
            'imagen' => 'nullable|string',
            'email' => 'nullable|email|email|unique:users,email,'.$id,
            
        ]);
        
        if ($validator->fails()) { 
            return self::respuestaError(400, $validator->errors());
        }
        if(strpos($request->imagen, ';base64')===FALSE){
            return self::respuestaError(400, "Imagen de perfil no cumple con el formato");
        }
       
        $estudiante = NULL;
        $profesor = NULL;
        $perfil = NULL;
        foreach ($input as $key => $value) 
        {
        	if(empty($value)){
        		unset($input[$key]);
        	}
        	else
        	{
        		if ($key == 'nombre' OR $key == 'apellido' OR $key == 'fecha_nacimiento' OR $key == 'direccion' OR $key == 'imagen') 
        		{
        			$perfil[$key] = $value;
        		}
        		elseif ($key == 'curriculum' OR $key == 'fecha_inicio' OR $key == 'fecha_fin') {
        			$profesor[$key] = $value;
        			$estudiante[$key] = $value;
        		}
        		else{
        			$profesor[$key] = $value;
        		}
        	}
        }
        $user = User::find($id);  
        if (!empty($user)) {
            $tipo = $user->getRoleNames();
            $id_pefil =  DB::table('perfil')->where('id_user', $id)->value('id');
            $profile = Perfil::find($id_pefil);
            if (!empty($input['email'])) {
            	$usuario['email'] =$input['email'];
	           	$user->update($usuario);
            }
            if (!empty($perfil)) {
            	$profile->update($perfil);
            }
            
        }
        else
        {
        	$tipo[0] = "otros";
        }
        
        switch ($tipo[0]) {
        	case 'estudiante':
        		$id_estudiante =  DB::table('estudiante')->where('id_user', $id)->value('id');
        		$student = Estudiante::find($id_estudiante);
                if ($estudiante) {
        		    $student->update($estudiante);
                }
        		break;
        	case 'profesor':
        		$id_profesor =  DB::table('profesor')->where('id_user', $id)->value('id');
        		$teacher = Profesor::find($id_profesor);
                if($profesor){
        		  $teacher->update($profesor);
                }
        		break;
        	
        	default:
        	    
        		return response()->json(['status' => "error", 'data' => $data]);
        		break;
        }
        
 		$data['results'] = $input;
 		return response()->json(['status' => "success", 'data' => $data]);
 		
       
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
