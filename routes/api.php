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


Route::middleware(['auth:api','dueno'])->group(function (){

    //Rutas de registro de gruas
    Route::apiResource('gruas','GruasController');

    //Rutas de registro de piloto
    Route::get('/choferes','ChoferController@index');
    Route::post('/choferes','ChoferController@createChofer');
    Route::delete('/choferes/{id}','ChoferController@delete');

    Route::get('/servicios/historico','ServicioController@indexRecord');

});

Route::middleware(['auth:api','cliente'])->group(function (){
    Route::post('/servicio','RequestServiceController@registerService');
    Route::post('buscar','BuscarGruaController@harvesine');
    Route::patch('/clienteevalua/{id}','EvaluacionController@clienteEvalua');
    Route::get('/clienteevalua/getinfo/{id}','EvaluacionController@getInfoChoferServicio');

    Route::get('/servicio/payable/{id}', 'RequestServiceController@isPayable');
    Route::get('/servicio/{id}', 'ServicioController@show');
    Route::get('/servicio/{id}/finalizable', 'RequestServiceController@isFinalizable');

    Route::get('/monto/{id}','RequestServiceController@getPrice');
    Route::get('/pagar/{id}','RequestServiceController@makePay');

    Route::get('/vehiculos', 'VehiculoController@index');
    Route::post('/vehiculos', 'VehiculoController@store');
    Route::get('/vehiculos/{id}', 'VehiculoController@show');
    Route::put('/vehiculos/{id}', 'VehiculoController@update');
    Route::delete('/vehiculos/{id}', 'VehiculoController@destroy');
});

Route::middleware(['auth:api','admin'])->group(function (){

    Route::apiResource('empresas','EmpresasController');
});

Route::middleware(['auth:api','piloto'])->group(function (){

    Route::post('/pilotoevalua/{id}','EvaluacionController@pilotoEvalua');

    //Rutas de servicio
    Route::get('/servicios','ServicioController@indexRequestedServices');
    Route::patch('/servicios/{idServicio}/take/{idPiloto}','RequestServiceController@takeRequest');

    //Ruta para subir foto
    Route::post('/subirfoto/{id}','FotoDanoController@uploadPhoto');

    Route::get('servicios/{id}/finalizar', 'RequestServiceController@finalizarServicio');

    Route::patch('servicios/{id}/describir','RequestServiceController@pilotoDescribirVehiculo');

    Route::get('/gruaspiloto','GruasController@index');
});