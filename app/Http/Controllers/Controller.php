<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function respuestaError($tipo = NULL, $detalle = NULL)
    {
        switch ($tipo) {
        	case 204:
        		
	        		$data['codigo']  = 204;
	       			$data['mensaje']  = "La petición se ha completado con éxito pero su respuesta no tiene ningún contenido";
        		break;
              	case 400:
        		
	        		$data['codigo']  = 400;
	       			$data['mensaje']  = "El servidor no puede procesar la solicitud";
        		break;
        	
        	default:
        		# code...
        		break;
        }
        if ($detalle) 
        {
	    	$data['detalle']  = $detalle;
		}

		if ($data) {
			//return response()->json([ 'status' => "error", 'data'=>$data]);
            return response()->json(['data'=>$data]);
		}
    }
    
}
