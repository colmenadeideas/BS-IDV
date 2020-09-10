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

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function verProfesores($status = 'active'){
        $results = DB::select("SELECT * FROM `teacher` as t, `users` as u WHERE  t.`id_user` = u.`id` AND t.`status` = ?", [$status]);
        return response()->json(['status' => "success", "data" => $results]);
    }

    public function verProfesor($id){
        if(empty($id)){
            return response()->json(['Error' => "empty id"]);
        }
        $results = DB::select("SELECT * FROM `teacher` as t, `users` as u WHERE t.`status` = 'active' AND t.`id_user` = u.`id` AND t.`id` = ?", [$id]);
        return response()->json(['status' => "success", "data" => $results]);
    }
    public function editar(Request $request){
        $validator = Validator::make($request->all(), [ 
          'name' => 'text', 
          'id'  => 'required'
        ]);

        if ($validator->fails()) 
        { 
          return response()->json([ 'error'=> $validator->errors() ]);
        }
        $data = $request->all();
        $id_user =  DB::table('teacher')->where('id', $data['id'])->value('id_user');
        if (!empty($data['name'])) {
                   $affected = DB::table('users')
                      ->where('id', $id_user)
                      ->update(['name' => $data['name']]);
             return response()->json(['status' => "success", "data" => $affected]);       
        }
        return response()->json(['status' => "no change"]);
    }

    public function crear(Request $request){
        $validator = Validator::make($request->all(), [ 
          'name' => 'required', 
          'email' => 'required|email', 
          'password' => 'required', 
          'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) 
        { 
          return response()->json([ 'error'=> $validator->errors() ]);
        }

        $data = $request->all();
        $data['role'] = 'teacher'; 
        $data['password'] = Hash::make($data['password']);
        $role = $data['role'];
        $user = User::create($data); 
        $user->assignRole($role);
        
        $person =  DB::table('person')->insertGetId(
                        ['id_user' => $user->id, 
                         'name' =>$data["name"],
                         'birthday' =>"1990-08-26",
                         'address' =>'address' ]);
        
        $teacher =  DB::table('teacher')->insertGetId(
                        ['id_user' => $user->id, 
                         'curriculum' =>"curriculum",
                         'start_date' =>"2020-08-26" ]);
        
        if (!empty($person) and !empty($teacher)) {
            return response()->json(['status' => "success"]);
        }
        else{
            return response()->json(["error" => "Techear not added"]);
        }
    }
    public function eliminar($id){
        $affected = DB::table('teacher')
                      ->where('id', $id)
                      ->update(['status' => 'inactive']);
        if ($affected > 0) {
            return response()->json(['status' => "success"]);
        }
        return response()->json(['status' => "no change"]);   
    }
}
