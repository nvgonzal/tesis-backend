<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\User;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**Lista las servicios solicitados a la empresa del usuario que hace la solicitud
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexRequestedServices(Request $request){
        $user = User::find($request->user()->id);
        $empresa_id = $user->chofer->empresa->id;
        $servicios = Servicio::creado($empresa_id)->get();
        return response()->json($servicios);
    }


    public function indexRecord(Request $request) {
        $user = User::find($request->user()->id);
        $empresa_id = $user->chofer->empresa->id;
        $servicios = Servicio::finalizado($empresa_id)->lastest()->get();
        return response()->json($servicios);
    }

    public function show(Request $request, $id) {
        $user = User::find($request->user()->id);
        $servicio = Servicio::find($id);
        if (!$servicio) {
            return response()->json(['error' => ['message' => 'No se ha encontrado el servicio']], 404);
        }
        if ($servicio->id_cliente != $user->cliente->id) {
            return response()->json(['message' => 'No autorizado'],403);
        }
        return response()->json($servicio, 200);
    }
}
