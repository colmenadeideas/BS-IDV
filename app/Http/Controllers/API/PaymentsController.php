<?php

namespace App\Http\Controllers\API;

use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use DB;

class PaymentsController extends Controller
{
    CONST HTTP_OK = Response::HTTP_OK;
  	CONST HTTP_CREATED = Response::HTTP_CREATED;
  	CONST HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    
    public function verPagosPorAprobar(){
    	$period  = DB::table('period')->where('status', 'active')->value('id');
   		$results = DB::select("SELECT u.`name`,d.`id` as `id_dues`,d.`amount`, d.`description` FROM `inscription` as i, `student` as s, `users` as u, `dues`  as d WHERE s.`id_user` = u.`id` AND i.`id_student` = s.`id` AND i.`id_payments` = d.`id_payments` AND d.`status` = 'pending' AND i.`id_period` = ?", [$period]);
   		return response()->json(['status' => "success", "data" => $results]);
	}

	public function registrarPagoEstudiante(Request $request){
	    $validator = Validator::make($request->all(), [ 
	      'id_student' => 'required', 
	      'amount' => 'required', 
	      'description' => 'required'
	    ]);

	    if ($validator->fails()) 
	    { 
	      return response()->json([ 'error'=> $validator->errors() ]);
	    }
    	$period  = DB::table('period')->where('status', 'active')->value('id');
  	
	    if(empty($period))
	    {
	  		return response()->json([ 'error'=> "Period not started" ]);
	  	}
	  	$data = $request->all();
	  	
	  	$student = DB::select("SELECT * FROM `inscription` WHERE `id_student` = ?", [$data['id_student']]);
	  	
	  	$dues = DB::table('dues')->insertGetId([
    							'id_payments' => $student[0]->{'id_payments'}, 
			    				'amount' =>$data['amount'],
       		    				'status' =>"pending",
			    				'description' =>$data['description']
  		]);
	  	if(!empty($dues)){
	  		return response()->json(['status' => "success"]);
	    }
	    else{
	    	return response()->json(["error" => "Dues not added"]);
	    }
	  	
	}
	
	public function verEstudiantesInscritos($period = NULL){
		if (empty($period)) {
			$period  = DB::table('period')->where('status', 'active')->value('id');
		}
   		$results = DB::select("SELECT u.`name`,u.`email`,u.`id`,i.`id_student`,i.`id_period`,i.`status` FROM `inscription` as i, `student` as s, `users` as u WHERE s.`id_user` = u.`id` AND i.`id_student` = s.`id` AND i.`id_period` = ?", [$period]);
   		return response()->json(['status' => "success", "data" => $results]);
	}
	public function gestionarPago(){
		
	}
}
