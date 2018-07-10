<?php

namespace App\Http\Controllers;

use App\Servicio;
use Illuminate\Http\Request;
use App\User;
use Validator;

class RequestServiceController extends Controller
{
    public function registerService(Request $request){
        $rules = [
            'id_empresa'    => 'required|exists:empresas,id',
            'id_vehiculo'   => 'required|exists:vehiculos,id',
            'ubicacion'     => 'required',
            'destino'       => 'required',
        ];
        $data = $request->only('id_empresa','id_vehiculo','ubicacion','destino');

        $validator = Validator::make($data,$rules);

        if ($validator->fails()){
            return response()->json(['message'=>'Hay errores en tus datos','errors'=>$validator->messages()]);
        }
        $user = User::find($request->user()->id);

        $clientID = $user->cliente->id;

        $servicio = new Servicio();

        $servicio->id_empresa   = $request->id_empresa;
        $servicio->id_vehiculo  = $request->id_vehiculo;
        $servicio->ubicacion    = $request->ubicacion;
        $servicio->destino      = $request->ubicacion;
        $servicio->id_cliente   = $clientID;

        $servicio->save();

        return response()->json(['message'=>'Servicio registrado.'],201);


    }

    /**Lista las servicios solicitados a la empresa del usuario que hace la solicitud
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexRequestedServices(Request $request){
        $user = User::find($request->user()->id);

        $servicios = $user->chofer->empresa->servicios;

        return response()->json($servicios);
    }

    /**Registra un servicio con el pilo
     *
     * @param Request $request
     * @param $idServicio
     * @param $idPiloto
     */
    public function takeRequest(Request $request, $idServicio ,$idPiloto){
        $servicio = Servicio::find($idServicio);
        $servicio->id_chofer = $idPiloto;
        $servicio->estado = 'tomado';
        $servicio->save();
    }

    public function makePay(){

    }
}
