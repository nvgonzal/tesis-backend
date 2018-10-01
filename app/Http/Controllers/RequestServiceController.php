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
            'descripcion'   => 'required'
        ];
        $data = $request->only('id_empresa','id_vehiculo','ubicacion','destino','descripcion');

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
        $servicio->descripcion  = $request->descripcion;

        $servicio->save();

        return response()->json($servicio,201);


    }

    /**Registra un servicio con el pilo
     *
     * @param Request $request
     * @param $idServicio
     * @param $idPiloto
     */
    public function takeRequest(Request $request, $idServicio ,$idPiloto){
        $rules = [
            'monto' => 'required|numeric',
            'id_grua' => 'required|exists:gruas,id'
        ];
        $data = $request->only('monto');

        $validator = Validator::make($data,$rules);

        if ($validator->fails()){
            return response()->json(['message'=>'Hay errores en tus datos','errors'=>$validator->messages()]);
        }
        $cliente = new \GuzzleHttp\Client();

        //$dolar;

        $servicio = Servicio::find($idServicio);
        $servicio->id_chofer = $idPiloto;
        $servicio->estado = 'tomado';
        $servicio->precio_final = $request->monto;
        $servicio->save();
    }

    public function makePay(Request $request,$id){
        $user = User::find($request->user()->id);
        $servicio = Servicio::find($id);
        if (!$servicio->estado == 'tomado'){
            return response()->json(['message' => 'El servicio no puede ser pagado'],422);
        }
        if ($servicio->id_cliente != $user->cliente->id){
            return response()->json(['message' => 'No puedes pagar ese servicio'],403);
        }

        $monto = $servicio->precio_final;
        $cuenta_pago = $servicio->empresa->cuenta_pago;

        $payController = new PaypalPaymentsController();

        $response = $payController->payService($monto,$cuenta_pago);

        return response()->json($response,$response['status']);
    }

    public function getPrice(Request $request, $id) {
        $servicio = Servicio::find($id);
        $user = User::find($request->user()->id);
        if ($servicio->id_cliente != $user->cliente->id) {
            return response()->json(['message' => 'No autorizado'],403);
        }
        return response()->json([
            'monto'             => $servicio->precio_final,
            'nombre_empresa'    => $servicio->empresa->nombre,
            'direccion'         => $servicio->empresa->direccion,
            'cuenta_pago'       => $servicio->empresa->cuenta_pago,]);

    }
}
