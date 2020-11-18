<?php

namespace App\Http\Controllers\API;

use App\User; 
use Validator;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use DB;

class ClasesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $tipo = 'online')
    {
        //turno es 'mañana' ,'tarde' 'no aplica'
        switch ($tipo) {
            case 'online':
                $validator = Validator::make($request->all(), [ 
                     'profesor' => 'required', 
                     'materia' => 'required',
                     'contenido' => 'required',
                     'turno' => 'required'
                    ]);   
                break;
            case 'presencial':
                $validator = Validator::make($request->all(), [ 
                     'profesor' => 'required', 
                     'materia' => 'required',
                     'contenido' => 'required',
                     'aula' => 'required',
                     'fecha' => 'required|date',
                     'turno' => 'required',
                     'aula' => 'required'
                    ]);
                break;
            
            default:
                # code...
                break;
        }

        if ($validator->fails()) 
        { 
            return response()->json([ 'status' =>'error', 'results' => $validator->errors() ]);
        }
        $data = $request->all();
        
        $data['periodo'] = DB::table('periodo')->where('status', 'activo')->value('id');

        $register = DB::select("SELECT * FROM `clase_profesor_materia` WHERE `id_materia` = ? AND `id_periodo`  = ?  AND `id_profesor` = ? AND `turno` = ? ",[$data['materia'],$data['periodo'], $data['profesor'], $data['turno']]);
        
        $programa =  DB::select("SELECT * FROM `programa` WHERE `id_materia` = ? AND `id_periodo`  = ?",[$data['materia'],$data['periodo']]);


       if (empty($register)) {
            $register =  DB::table('clase_profesor_materia')->insertGetId(
                            [
                                'id_materia' => $data['materia'], 
                                'id_programa' => $programa[0]->{'id'}, 
                                'id_profesor'=> $data['profesor'], 
                                'turno'=> $data['turno']
                            ]);
       }
       else
       {
            $register = $register[0]->{'id'};

       }
       $now = new \DateTime();
       $now = $now->format('Y-m-d');
        switch ($tipo) {
            case 'online':
               $clase =  DB::table('clase')->insertGetId(
                            [
                                'id_clase_profesor_materia' => $register, 
                                'tipo' => 'online', 
                                'contenido'=> $data['profesor'],
                                'clase_creada' => $now
                                
                            ]);
               break;
            case 'presencial':
                $clase =  DB::table('clase')->insertGetId(
                          [
                                'id_clase_profesor_materia' => $register, 
                                'tipo' => 'online', 
                                'aula' => $data['id_aula'], 
                                'contenido'=> $data['profesor'],
                                'fecha' => $data['fecha'],
                                'clase_creada' => $now
                           ]);   
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
    public function show($codigoMat = NULL)
    {
        $periodo = DB::table('periodo')->where('status', 'activo')->value('id'); 
        if (!empty($codigoMat)) {
           
            //$materia =  DB::select("SELECT `m`.`id`, `m`.`nombre`,`c`.`nombre` as `especialidad`, `dias` as `horario` FROM `carrera_tiene_materia` as `ctn` ,`carrera` as `c`, `materia` as `m`, `clase_profesor_materia` as `cpm`, `programa` as `p` WHERE `ctn`.`id_carrera` = `c`.`id` AND `m`.`status` = 'activo' AND `ctn`.`id_materia` = `m`.`id` AND `m`.`id` = `cpm`.`id_materia` AND `cpm`.`id_programa` =`p`.`id` AND  `m`.`id` = ?", [$codigoMat]);
            
            $results = DB::select("SELECT `c`.`id`, `c`.`nombre`,`clase_creada` as `creation_date`,imagen,evaluada FROM `clase_profesor_materia` as cpm, `clase` as c, `aula` as a, `programa` as p,`materia` as `m` WHERE m.`id` = ? AND cpm.`id_materia` = m.`id` AND p.`id_materia`= cpm.`id_materia` AND cpm.`id` = c.`id_clase_profesor_materia` AND p.`id_periodo` = ?", [$codigoMat,$periodo]);   
            
            $data = json_decode(json_encode($results),true);
            //$data['materia'] =json_encode($materia) ;
            if (empty($results)) {
                 return response()->json([ 'status' => "error", 'results' => "La materia no tiene clases cargadas"]); 
            }
           return response()->json([ 'status' => "success", 'results' =>$data]);
       }
       else
       {
            $results['materias'] = DB::select("SELECT c.`id` as `id_clase`,`clase_creada`,`fecha`,`tipo`,`contenido`, `Nombre` as `nombre del aula`, `codigo`, `ubicacion` FROM `clase_profesor_materia` as cpm, `clase` as c, `aula` as a, `programa` as p WHERE cpm.`id` = c.`id_clase_profesor_materia` AND p.`id_periodo` = ?", [$codigoMat,$periodo]); 
            if (empty($results)) {
                 return response()->json([ 'status' => "error", 'results' => "No hay clases cargadas" ]); 
            }
           return response()->json([ 'status' => "success", 'results'=>$data]);
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
        $validator = Validator::make($request->all(), [ 
                     'clase_creada'=> 'date',  
                     'fecha'=> 'date',    
                     'id_aula'=> 'numeric',  
                     'tipo'=> 'string' 
                    ]);
        if ($validator->fails()) 
        { 
            return response()->json([ 'error'=> $validator->errors() ]);
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
        
    }
    public function cslug(){

        $materias =  DB::select("SELECT m.`id`,m.`nombre`, c.`nombre` as `carrera` FROM `carrera_tiene_materia` as ctm ,`materia` as m,`carrera` as c WHERE ctm.`id_materia` = m.`id` AND ctm.`id_carrera` = c.`id`");
         $slug_desc ="";
        foreach ($materias as $materia ) {
           $slug_materia = preg_replace('/[^A-Za-z0-9-]+/','-',$materia->{'nombre'});
           
           switch ($materia->{'carrera'}) {
               case 'Año Basico':
                   $slug_desc = 'basico';
                   break;
            case 'Diseño Grafico':
                    $slug_desc = 'grafico';
                   break;
            case 'Diseño de Modas':
                    $slug_desc = 'moda';
                   break; 
            case 'Ilustración':
                    $slug_desc = 'ilustracion';
                break;
            case 'Diseño Industrial':
                     $slug_desc = 'industrial';
                break;
            case 'Diseño de interiores':
                     $slug_desc = 'interiores';
                  break;             
               default:
                   # code...
                   break;
           }
           $slug = $slug_desc."-".$slug_materia;

           $slug = strtolower($slug);
           
           DB::table('materia')
                ->where('id', $materia->{'id'})
                ->update(['slug' => $slug]);
        }
        echo "listo";

   
    }
}
