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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Inscripciones
Route::post('login', 'API\AuthController@login');
Route::post('add/Periodo', 'API\RegistrationController@nuevoPeriodo');
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
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
