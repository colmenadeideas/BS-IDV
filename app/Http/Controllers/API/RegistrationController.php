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

class RegistrationController extends Controller
{
  CONST HTTP_OK = Response::HTTP_OK;
  CONST HTTP_CREATED = Response::HTTP_CREATED;
  CONST HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
  public function prueba(){
    echo "eliminado"; 
   
   
  }
  public function nuevoEstudiante(Request $request){ 

    $validator = Validator::make($request->all(), [ 
      'name' => 'required', 
      'email' => 'required|email', 
      'password' => 'required', 
      'password_confirmation' => 'required|same:password', 
      'career' => 'required'
    ]);

    if ($validator->fails()) 
    { 
      return response()->json([ 'error'=> $validator->errors() ]);
    }
    $results = DB::select("SELECT * FROM `period` WHERE `status` = 'active'");
  	
    if(!empty($results))
    {
  		$period = $results[0]->{'id'};
  	}
  	else
  	{
  		return response()->json([ 'error'=> "Period not started" ]);
  	}

    $data = $request->all();
    $data['role'] = 'student'; 
    $data['password'] = Hash::make($data['password']);
    $role = $data['role'];
    $user = User::create($data); 
    $user->assignRole($role);
    
    $person =  DB::table('person')->insertGetId(
			    	['id_user' => $user->id, 
			    	 'name' =>$data["name"],
			    	 'birthday' =>"1990-08-26",
			    	 'address' =>'address' ]);
    
    $student =  DB::table('student')->insertGetId(
			    	['id_user' => $user->id, 
			    	 'curriculum' =>"curriculum",
			    	 'start_date' =>"2020-08-26" ]);
    //pagos de carrera
    $results = DB::select("SELECT * FROM `cost` WHERE `semester` = 1 AND `id_career` = ?", [$data['career']]);

    $payment = DB::table('payments')->insertGetId([
                  'amount' => $results[0]->{'amount'}, 
                  'description' =>"Monto a cancelar",
                  'status' =>"pending"]);
    DB::table('pay_for')->insert([
                  'id_cost' => $results[0]->{'id'}, 
                  'id_payments' => $payment, 
                  'id_career' =>$data['career'] ]);

    $inscription = DB::table('inscription')->insertGetId([
    							'id_student' => $student, 
			    				'id_period' =>$period,
                  'id_payments' =>$payment,
			    				'status' =>"pending",
			    				'semester' =>1
    ]);
    if (!empty($person) and !empty($student) and !empty($inscription)) {
    	return response()->json(['status' => "success"]);
    }
    else{
    	return response()->json(["error" => "Student not added"]);
    }
  }

  public function nuevoPeriodo(Request $request){
 
  	$results = DB::select("SELECT * FROM `period` WHERE `status` = 'active'");
  	if(!empty($results)){
  		DB::table('period')
            ->where('id', $results[0]->{'id'})
            ->update(['status' => 'inactive']);
  	}
  	$validator = Validator::make($request->all(), [ 
      'code' => 'required', 
      'start' => 'required|date', 
      'end' => 'required|date'
    ]);
  	if ($validator->fails()) { 
      	return response()->json([ 'error'=> $validator->errors() ]);
    }
    $data = $request->all(); 
    $id = DB::table('period')->insertGetId(
			    	['code' => $data["code"], 
			    	 'start_date' =>$data["start"],
			    	 'end_date' =>$data["end"],
			    	 'status' =>'active' ]);
    $success["id"] = $id;
    $response =  self::HTTP_CREATED;
    
    return response()->json(['status' => "success"]);

  }

}
