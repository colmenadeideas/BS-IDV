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

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');
Route::post('registerpp', 'API\AuthController@registerpp');
Route::get('matter', 'API\MatterController@store');

Route::middleware('auth:api','cors')->group(function(){
	Route::post('details', 'API\AuthController@get_user_details_info'); 
	Route::post('schedule/edit', 'API\ScheduleController@edit')->name('edit schudele')->middleware('permission:edit schudele');
	Route::post('schedule/show', 'API\ScheduleController@show')->name('show schudele')->middleware('permission:show schudele');
	Route::get('notes', 'API\MatterController@notes')->name('save notes')->middleware('permission:save notes');

});

