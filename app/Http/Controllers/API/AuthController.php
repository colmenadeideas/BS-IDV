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

class AuthController extends Controller 
{
  
  CONST HTTP_OK = Response::HTTP_OK;
  CONST HTTP_CREATED = Response::HTTP_CREATED;
  CONST HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;

  public function login(Request $request){ 

    $credentials = [

        'email' => $request->email, 
        'password' => $request->password

    ];

    if( auth()->attempt($credentials) ){ 

      $user = Auth::user(); 
      
      $token['role'] = $user->getRoleNames();
      $token['token'] = $this->get_user_token($user,"TestToken");
      $token['name'] =  $user->name;
      $token['period'] =  DB::table('period')->where('status', 'active')->value('id');
      $response = self::HTTP_OK;
      

      return $this->get_http_response( "success", $token, $response );

    } else { 

      $error = "Unauthorized Access";

      $response = self::HTTP_UNAUTHORIZED;

      return $this->get_http_response( "Error", $error, $response );
    } 

  }
    
  public function register(Request $request) 
  { 
    $validator = Validator::make($request->all(), [ 

      'name' => 'required', 
      'email' => 'required|email', 
      'password' => 'required', 
      'password_confirmation' => 'required|same:password', 
      //'role' => 'required',  // por ahora 


    ]);

    if ($validator->fails()) { 

      return response()->json([ 'error'=> $validator->errors() ]);

    }

    $data = $request->all(); 
    $dat['role'] = 'student'; //remove
    $data['password'] = Hash::make($data['password']);
    $role = $data['role'];
    $user = User::create($data); 
    $user->assignRole($role);
    $success['token'] = $this->get_user_token($user,"TestToken");
    $success['name'] =  $user->name;
    $success['role'] = $user->getRoleNames();
    $response =  self::HTTP_CREATED;

    return $this->get_http_response( "success", $success, $response );

  }
  
 
  public function update(Request $request, $id)
  {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
  }

  public function get_user_details_info() 
  { 

    $user = Auth::user(); 

    $response =  self::HTTP_OK;

    return $user ? $this->get_http_response( "success", $user, $response )
                   : $this->get_http_response( "Unauthenticated user", $user, $response );

  } 

  public function get_http_response( string $status = null, $data = null, $response ){

    return response()->json([

        'status' => $status, 
        'data' => $data,

    ], $response);
  }

  public function get_user_token( $user, string $token_name = null ) {

     return $user->createToken($token_name)->accessToken; 

  }

}