<?php

use Illuminate\Http\Request;

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

Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');




Route::apiResource('empresas','EmpresasController')->middleware('auth:api');


Route::apiResource('gruas','GruasController');

//@TODO borrar despues.Solo para pruebas
Route::post('pagar','RequestServiceController@makePay');


Route::middleware(['auth:api','dueno'])->group(function (){

    //Rutas de registro de piloto
    Route::get('/choferes','ChoferController@index');
    Route::post('/choferes','ChoferController@createChofer');
    Route::delete('/choferes/{id}','ChoferController@delete');

    //Rutas de servicio
    Route::get('/servicios','RequestServiceController@indexRequestedServices');
});

Route::middleware(['auth:api','cliente'])->group(function (){
    Route::post('/servicio','RequestServiceController@registerService');
    Route::post('buscar','BuscarGruaController@harvesine');
});

Route::middleware(['auth:api','admin'])->group(function (){

});

Route::middleware(['auth:api','piloto'])->group(function (){

});