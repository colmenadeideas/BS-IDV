<?php

namespace App\Http\Controllers\API;

use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use DB;

class LessonController extends Controller
{
    public function crearProgram(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
          'id_subject_matter' => 'required', 
          'id_teacher' => 'required',
          'start_date' => 'required|date', 
          'end_date' => 'required|date'

        ]);

        if ($validator->fails()) 
        { 
          return response()->json([ 'error'=> $validator->errors() ]);
        }

        $data = $request->all();
        // Programa de estudio 
        $period  = DB::table('period')->where('status', 'active')->value('id');
        if (empty($sp)) 
        { 
          return response()->json([ 'error'=> "Period not started" ]);
        }

        $lts = DB::table('lesson_teacher_matter')->insertGetId([
                                'id_subject_matter' => $data['id_subject_matter'],
                                'id_period' => $sp,
                                'id_teacher' => $data['id_teacher']
        ]);

        if (empty($lts)) 
        { 
          return response()->json([ 'error'=> "Error!" ]);
        }
        return response()->json(['status' => "success", "data" => $data]);

    }
    public function verClases($id_materia, $periodo ){
        if (empty($periodo)){
            $period  = DB::table('period')->where('status', 'active')->value('id');
        }
    }
    
}