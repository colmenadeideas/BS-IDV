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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/



Route::post('login', 'API\AuthController@login');
Route::post('programa','API\ProgramaController@store');
Route::get('programa/{materia?}','API\ProgramaController@show');

Route::get('perfil/{id}','API\PerfilController@show');

//Periodo

Route::post('periodo','API\PeriodoController@store');
Route::put('periodo/{codigo}','API\PeriodoController@update');
Route::delete('periodo/{codigo}','API\PeriodoController@destroy');
Route::get('periodo/{id}','API\PeriodoController@show');//Periodo

//Materia
Route::post('materias','API\MateriasController@store');
Route::put('materias/{codigo}','API\MateriasController@update');
Route::delete('materias/{codigo}','API\MateriasController@destroy');
Route::get('materias/','API\MateriasController@show');
Route::get('materia/{id}','API\MateriasController@show');
Route::get('materia/{id}/','API\MateriasController@show');
Route::get('materia/{id?}/clases','API\ClasesController@show');

//Estudiantes

Route::post('estudiante/{tipo?}','API\EstudiantesController@store');
Route::put('estudiante/{id}','API\EstudiantesController@update');
Route::delete('estudiante/{id}','API\EstudiantesController@destroy');
Route::get('estudiantes/{id?}/{contenido?}/{periodo?}','API\EstudiantesController@show');
Route::get('estudiante/{id}','API\EstudiantesController@show');

//clases
Route::post('clase/{tipo?}','API\ClasesController@store');
Route::put('clases/{id?}','API\ClasesController@update');
Route::delete('clases/{id}','API\ClasesController@destroy');
Route::get('clases/{id?}','API\ClasesController@show');

//Profesores
Route::post('profesor/{tipo?}','API\ProfesoresController@store');
Route::put('profesor/{id}/{tipo?}','API\ProfesoresController@update');
Route::put('profesor/{codigo}','API\ProfesoresController@update');
Route::delete('profesor/{codigo}','API\ProfesoresController@destroy');
Route::get('profesor/{id?}','API\ProfesoresController@show');
Route::get('show','API\ProfesoresController@run');
Route::get('profesores','API\ProfesoresController@show');
Route::get('credenciales','API\ProfesoresController@emails');


//aux 
Route::get('cslug','API\ClasesController@cslug');

/*Route::post('add/Periodo', 'API\RegistrationController@nuevoPeriodo');
Route::post('add/Estudiante', 'API\RegistrationController@nuevoEstudiante');

//PAGOS
Route::get('view/Estudiantes/{periodo?}', 'API\PaymentsController@verEstudiantesInscritos');
Route::get('view/Pagos', 'API\PaymentsController@verPagosPorAprobar');
Route::post('update/Pagos', 'API\PaymentsController@registrarPagoEstudiante');
Route::post('edit/Pagos', 'API\PaymentsController@gestionarPago');
Route::get('add/delete/{id?}', 'API\RegistrationController@prueba');

//Profesor
Route::get('view/Profesores/{status?}', 'API\TeacherController@verProfesores');
Route::get('view/Profesor/{id}', 'API\TeacherController@verProfesor');
Route::post('create/Profesor', 'API\TeacherController@crear');
Route::put('edit/Profesor', 'API\TeacherController@editar');
Route::delete('delete/Profesor/{id}', 'API\TeacherController@eliminar');
//Progama de estudio
Route::get('create/Progama','API\StudyProgramController@create');


/*Route::middleware('auth:api')->group(function(){

	Route::post('IniciarPeriodo', 'API\RegistrationController@nuevoPeriodo')->name('nuevoPeriodo Registration')->middleware('permission:nuevoPeriodo Registration');
	
	Route::post('NuevoEstudiante', 'API\RegistrationController@nuevoEstudiante')->name('nuevoEstudiante Registration')->middleware('permission:nuevoEstudiante Registration');
	
	Route::post('EstudiantesInscritos', 'API\PaymentsController@verEstudiantesInscritos')->name('verEstudiantesInscritos Payments')->middleware('permission:verEstudiantesInscritos Payments');
	
	Route::post('PagosPorAprobar', 'API\PaymentsController@verPagosPorAprobar')->name('verPagosPorAprobar PaymentverPagosPorAprobar Payments')->middleware('permission:verPagosPorAprobar Payments');
	
	Route::post('PagoEstudiante', 'API\PaymentsController@registrarPagoEstudiante')->name('registrarPagoEstudiante Payments')->middleware('permission:registrarPagoEstudiante Payments');

	Route::post('GestionarPago', 'API\PaymentsController@gestionarPago')->name('gestionarPago Payments')->middleware('permission:gestionarPago Payments');
});
*/
 
// Clear application cache:
 Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
     return 'Application cache cleared';
 });
