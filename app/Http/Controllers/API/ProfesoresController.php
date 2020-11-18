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
use Illuminate\Support\Str;
use DB;

class ProfesoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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

            default:
                # code...
                break;
        }
    }
    public function nuevo($data)
    {

            $data['role'] = 'profesor'; 
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
            $profesor =  DB::table('profesor')->insertGetId(
                            ['id_user' => $user->id, 
                             'curriculum' =>"curriculum",
                             'fecha_inicio' =>"2020-08-26" ]);
            
            
            if (!empty($person) and !empty($user) and !empty($profesor)) {
                return response()->json(['status' => "success"]);
            }
            else{
                return response()->json(['status' =>'error', 'data' => "El Profesor  no ha sido agregado"]);
            }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
       if (!empty($id)) {
             $profesor = DB::select("SELECT * FROM `users` as u, `perfil` as p, `profesor` as pr  WHERE pr.`id_user` = u.`id` AND p.`id_user` = pr.`id_user` AND  pr.`status` = 'activo' AND pr.`id` = ?", [$id]);   
            if (empty($profesor)) {
                 return response()->json([ 'status' =>'error', 'data' =>"No existe el profesor"]); 
            }
           return response()->json([ 'status' => "success", 'data'=>$profesor]);
       }
       else
       {
            $profesor = DB::select("SELECT * FROM `users` as u, `perfil` as p, `profesor` as pr  WHERE pr.`id_user` = u.`id` AND p.`id_user` = pr.`id_user` AND  pr.`status` = 'activo' ");   
            if (empty($profesor)) {
                 return response()->json([ 'status' =>'error', 'data' =>"No hay profesores"]); 
            }
           return response()->json([ 'status' => "success", 'data'=>$profesor]);
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $tipo = NULL)
    {
        switch ($tipo) {
            case 'reset':
               $this->validate($request, [
           
                'password' => 'required'
            
                ]);
            
                $input = $request->all();
                if(!empty($input['password'])){ 
                    $input['password'] = Hash::make($input['password']);
                }else{
                    $input = array_except($input,array('password'));    
                }
            
                $user = User::find($id);
                $user->update($input);
                
            
                $user->assignRole($request->input('roles'));
            
                return redirect()->route('users.index')
                                ->with('success','Contraseña actualizada exitosamente');
            break;
            
            default:
                # code...
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('profesor')
                ->where('id', $id)
                ->update(['status' => 'inactivo']);

        if (empty($delete)) {
               return response()->json([ 'status' =>'error', 'data' => "No se pudo eliminar al profesor"]); 
        }
           return response()->json([ 'status' => "success"]);
    }

    public function email(){
         $profesor = DB::select("SELECT * FROM `users` as u, `perfil` as p, `profesor` as pr  WHERE pr.`id_user` = u.`id` AND p.`id_user` = pr.`id_user` AND  pr.`status` = 'activo' ");   
        return $Profesor;


    }
}
