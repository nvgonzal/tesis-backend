<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/paypal/aprovado','PaypalPaymentsController@approved');
Route::view('/pago/cancelado','paypal_payment.cancel');

Route::view('/pago/aprovado','paypal_payment.aprovado');