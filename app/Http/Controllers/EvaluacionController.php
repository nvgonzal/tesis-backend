<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Servicio;
use App\Cliente;


class EvaluacionController extends Controller
{


    /*ev cliente*/

    public function clienteEvalua(Request $request, $id)
    {
        try{
            $user = User::findOrFail($request->user()->id);
            $servicio = Servicio::findOrFail($id);

            $empresa = Empresa::findOrFail($servicio->id_empresa);
            $servicio->evaluacion_cliente = $request->evaluacion_cliente;
            $servicio->save();

            $avg = DB::table('servicios')
                ->where('id_empresa',$servicio->id_empresa)
                ->where('estado','finalizado')
                ->avg('evaluacion_cliente');

            $empresa->valoracion = $avg;
            $empresa->save();


            $msg = ['message' => 'Evaluacion a' . $empresa->nombre . 'Completa', 'data' => $servicio];
            return response()->json($msg,201);
        }catch (Exception $e){
            return response()->json('error al evaluar', $e);
        }

    }

    public function pilotoEvalua (Request $request, $id)
    {
        try{

            $user = User::findOrFail($request->user()->id);
            $servicio = Servicio::findOrFail($id);

            $cliente = Cliente::findOrFail($servicio->id_cliente);

            $servicio->evaluacion_empresa = $request->evaluacion_empresa;
            $servicio->save();

            $avg = DB::table('servicios')
                ->where('id_cliente',$servicio->id_cliente)
                ->where('estado' , 'finalizado')
                ->avg('evaluacion_empresa');

            $cliente->valoracion = $avg;
            $cliente->save();

            return response()->json($avg);

        }catch (Exception $e){

            return response()->json('Problema al evaluar a cliente');
        }
    }
}
