<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\AuthController@login');

//Programa
Route::post('programa','API\ProgramaController@store');
Route::get('programa/{materia?}','API\ProgramaController@show');

//Periodo

Route::post('periodo','API\PeriodoController@store');
Route::put('periodo/{codigo}','API\PeriodoController@update');
Route::delete('periodo/{codigo}','API\PeriodoController@destroy');
Route::get('periodo/{id}','API\PeriodoController@show');//Periodo

//Materia


Route::get('materias/','API\MateriasController@show');
Route::get('materia/{id}','API\MateriasController@show');
Route::get('materia/{id?}/{clases}','API\ClasesController@show');


//Carrera
Route::get('carrera/{id?}','API\CarreraController@show');
Route::get('carreras/','API\CarreraController@show');
Route::get('carreras/{id}/periodo/{id_p}','API\CarreraController@showCarrera');
Route::get('carreras/{id}/{periodo?}','API\CarreraController@show');
//Estudiantes

Route::post('estudiante/{tipo?}','API\EstudiantesController@store');

//Route::get('estudiantes/{id?}/{contenido?}/{periodo?}','API\EstudiantesController@show');
//Route::get('estudiantes/{qty?}/{contenido?}/{id?}','API\EstudiantesController@show');

Route::get('estudiante/{id}','API\EstudiantesController@MostrarEstudiante');
Route::get('estudiantes/{id_periodo?}','API\EstudiantesController@MostrarEstudiantes');
Route::get('cuenta','API\EstudiantesController@index');
//estudiantes con roles
Route::middleware('auth:api')->group(function(){
	Route::get('estudiates/lista/{periodo?}', 'API\EstudiantesController@MostrarEstudiantesAdmin')->name('MostrarEstudiantesAdmin Estudiantes')->middleware('permission:MostrarEstudiantesAdmin Estudiantes');
});

//clases
Route::post('clase/{tipo?}','API\ClasesController@store');
Route::put('clases/{id?}','API\ClasesController@update');
Route::delete('clases/{id}','API\ClasesController@destroy');
Route::get('clase/{id?}','API\ClasesController@show');



//Profesores
Route::post('profesor/{tipo?}','API\ProfesoresController@store');
Route::put('profesor/{id}/{tipo?}','API\ProfesoresController@update');
Route::put('profesor/{codigo}','API\ProfesoresController@update');
Route::delete('profesor/{codigo}','API\ProfesoresController@destroy');
Route::get('profesor/{id?}','API\ProfesoresController@show');
Route::get('profesor/{id?}/{materias?}','API\ProfesoresController@show');
Route::get('profesores','API\ProfesoresController@show');


//Notas

Route::get('notas/{tipo?}','API\NotasController@show');
Route::get('notas/{tipo?}/{id?}','API\NotasController@show');
Route::put('nota/{id?}','API\NotasController@update');
//Route::post('nota/{id?}','API\NotasController@update');
Route::put('nota/clase/{claseID}/estudiante/{estudianteID}','API\NotasController@update');



//Perfil

Route::get('user/{id?}','API\UserController@show');
Route::put('user/{id?}','API\UserController@update');
Route::get('users','API\UserController@show');
Route::get('perfil/{id}','API\PerfilController@show');

//seguridad

//Route::post('seguridad/{id}/{token?}', 'API\AuthController@UpdatePassword');
Route::put('/user/seguridad/{id}', 'API\AuthController@UpdatePassword');


//Chat
Route::post('chat/{tipo?}/{id_sender?}/receiver/{id_receiver?}','API\ChatController@store');
Route::get('chat/{tipo?}/{id_sender?}/receiver/{id_receiver?}/qty/{qty?}','API\ChatController@show');
Route::get('chat/{tipo?}/','API\ChatController@show');//estudiantes y profesores
Route::get('chat/{tipo?}/{id_sender?}','API\ChatController@show');//rol



//aux 
Route::get('cslug','API\ClasesController@cslug');
Route::get('credenciales','API\ProfesoresController@emails');
Route::get('show','API\ProfesoresController@run');
Route::get('estudiantes1/add','API\EstudiantesController@add');

//Route::post('imagen','API\RespuestaController@show');//rol
Route::post('imagen','API\RespuestaController@store');//rol


 
// Clear application cache:
 Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    //$exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
     return 'Application cache cleared';
 });
 