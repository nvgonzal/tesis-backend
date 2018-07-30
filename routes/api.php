<?php

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


//@TODO borrar despues.Solo para pruebas
Route::post('pagar','RequestServiceController@makePay');


Route::middleware(['auth:api','dueno'])->group(function (){

    //Rutas de registro de gruas
    Route::apiResource('gruas','GruasController');

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
    Route::post('/clientevalua/{id}','EvaluacionController@clienteEvalua');
});

Route::middleware(['auth:api','admin'])->group(function (){

    Route::apiResource('empresas','EmpresasController');
});

Route::middleware(['auth:api','piloto'])->group(function (){

    Route::post('/pilotoevalua/{id}','EvaluacionController@pilotoEvalua');

    //Ruta para subir foto
    Route::post('/subirfoto/{id}','FotoDanoController@uploadPhoto');
});