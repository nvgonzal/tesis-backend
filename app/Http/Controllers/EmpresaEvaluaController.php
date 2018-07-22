<?php

namespace App\Http\Controllers;

use App\User;
use App\Servicio;
use App\Cliente;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EmpresaEvaluaController extends Controller
{
    public function pilotoEvalua (Request $request)
    {
        try{

            $user = User::findOrFail($request->user()->id);
            $servicio = Servicio::findOrFail($request->id);

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
