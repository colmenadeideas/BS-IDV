<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function respuestaError($tipo = NULL, $detalle = NULL)
    {
        switch ($tipo) {
        	case 204:
        		
	        		$data['code']  = 204;
                    $data['message']['title'] = "The request has been completed successfully but your response has no content";
                    $data['message']['details'] = $detalle;
                    $data['results']  = array();
        		break;
              	case 400:
        		
	        		$data['code']  = 400;
                    $data['message']['title'] = "The request has been completed successfully but your response has no content";
                    $data['message']['details'] = "The following fields need to be corrected";
                    $data['message']['validation'] = $detalle;
                    $data['results']  = array();

        		break;
        	
        	default:
        		# code...
        		break;
        }
        
		if ($data) {
            return response()->json(['data'=>$data]);
		}
    }
    public function saveImageBase64($image = NULL,$nombre)
    {
        if(!empty($image) && strpos($image, ';base64')){
            $base64 = $image;
            //obtem a extensão
            $extension = explode('/', $base64);
            $extension = explode(';', $extension[1]);
            $extension = '.'.$extension[0];
            //gera o nome
            $name = "perfil-".$nombre."-".time().$extension;
            //obtem o arquivo
            $separatorFile = explode(',', $base64);
            $file = $separatorFile[1];
            $path = 'public/perfil-base64-files/';
            //envia o arquivo
            Storage::put($path.$name, base64_decode($file));
            return $path.$name;
           

        }else{
            return false;
        }
    }
    
}
