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
}
