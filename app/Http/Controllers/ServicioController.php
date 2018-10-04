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
        $lista = [];
        foreach ($servicios as $servicio) {
            $item = [
                'id' => $servicio->id,
                'id_empresa' => $servicio->id_empresa,
                'id_chofer' => $servicio->id_chofer,
                'id_grua' => $servicio->id_vehiculo,
                'alta_gama' => $servicio->alta_gama,
                'ubicacion' => $servicio->ubicacion,
                'destino' => $servicio->destino,
                'estado' => $servicio->estado,
                'created_at' => [
                    'human' => $servicio->created_at->diffForHumans(),
                    'fecha' => $servicio->created_at->toDateTimeString()
                ],
                'descripcion' => $servicio->descripcion,
                'descripcion_chofer' => $servicio->descripcion_chofer,
                'evaluacion_cliente' => $servicio->evaluacion_cliente,
                'evaluacion_empresa' => $servicio->evaluacion_empresa,
                'precio_dolar' => $servicio->precio_dolar,
                'precio_pesos' => $servicio->precio_pesos,
                'precio_final' => $servicio->precio_final,
                'chofer_info' => $servicio->chofer->usuario->toArray(),
                'vehiculo_info' => $servicio->vehiculo->toArray(),
                'cliente_info' => $servicio->cliente->usuario->toArray(),
            ];
            array_push($lista,$item);
        }
        return response()->json($lista);
    }


    public function indexRecord(Request $request) {
        $user = User::find($request->user()->id);
        $empresa_id = $user->chofer->empresa->id;
        $servicios = Servicio::finalizado($empresa_id)->latest()->get();
        $lista = [];
        foreach ($servicios as $servicio) {
            $item = [
                'id' => $servicio->id,
                'id_empresa' => $servicio->id_empresa,
                'id_chofer' => $servicio->id_chofer,
                'id_grua' => $servicio->id_vehiculo,
                'alta_gama' => $servicio->alta_gama,
                'ubicacion' => $servicio->ubicacion,
                'destino' => $servicio->destino,
                'estado' => $servicio->estado,
                'created_at' => [
                    'human' => $servicio->created_at->diffForHumans(),
                    'fecha' => $servicio->created_at->toDateTimeString()
                ],
                'descripcion' => $servicio->descripcion,
                'descripcion_chofer' => $servicio->descripcion_chofer,
                'evaluacion_cliente' => $servicio->evaluacion_cliente,
                'evaluacion_empresa' => $servicio->evaluacion_empresa,
                'precio_dolar' => $servicio->precio_dolar,
                'precio_pesos' => $servicio->precio_pesos,
                'precio_final' => $servicio->precio_final,
                'chofer_info' => $servicio->chofer->usuario->toArray(),
                'vehiculo_info' => $servicio->vehiculo->toArray(),
                'cliente_info' => $servicio->cliente->usuario->toArray(),
            ];
            array_push($lista,$item);
        }
        return response()->json($lista);
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
