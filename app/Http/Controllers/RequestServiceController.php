<?php

namespace App\Http\Controllers;

use App\Servicio;
use GuzzleHttp\Exception\ClientException;
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
     * @param $idUserPiloto
     */
    public function takeRequest(Request $request, $idServicio , $idUserPiloto){
        $servicio = Servicio::find($idServicio);
        $user = User::find($request->user()->id);
        if ($servicio->id_empresa != $user->chofer->empresa->id) {
            return response()->json(['message' => 'No autorizado'],403);
        }
        $rules = [
            'monto' => 'required|numeric',
            'id_grua' => 'required|exists:gruas,id'
        ];
        $data = $request->only('monto','id_grua');

        $validator = Validator::make($data,$rules);

        if ($validator->fails()){
            return response()->json(['message'=>'Hay errores en tus datos','errors'=>$validator->messages()]);
        }
        // Inicio de calculo de precio
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->get('https://mindicador.cl/api/dolar');
        } catch (ClientException $e) {
            return response()->json(['message' => 'Error al obtener el precio del dolar']);
        }
        $response = \GuzzleHttp\json_decode($response->getBody());

        $responseBody = json_decode(json_encode($response),true);

        $dolar = $responseBody['serie'];

        $precio_dolar = $dolar[0]['valor'];

        $precio_final = intval($request->monto) / $precio_dolar;
         // Fin calculo de precio

        $userPiloto = User::find($idUserPiloto);

        $servicio = Servicio::find($idServicio);
        $servicio->id_chofer = $userPiloto->chofer->id;
        $servicio->id_grua = $request->id_grua;
        $servicio->estado = 'tomado';
        $servicio->precio_final = $precio_final;
        $servicio->precio_dolar = $precio_dolar;
        $servicio->precio_pesos = $request->monto;
        $servicio->save();

        return response()->json(['message' => 'Servicio tomado']);
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

        $response = $payController->payService($monto,$cuenta_pago,$servicio);

        return response()->json($response,$response['status']);
    }

    public function getPrice(Request $request, $id) {
        $servicio = Servicio::find($id);
        $user = User::find($request->user()->id);
        if ($servicio->id_cliente != $user->cliente->id) {
            return response()->json(['message' => 'No autorizado'],403);
        }
        return response()->json([
            'precio_final'      => $servicio->precio_final,
            'nombre_empresa'    => $servicio->empresa->nombre,
            'direccion'         => $servicio->empresa->direccion,
            'cuenta_pago'       => $servicio->empresa->cuenta_pago,
            'monto'             => $servicio->precio_pesos,
            'valor_dolar'       => $servicio->precio_dolar,
            ]);

    }

    public function isPayable(Request $request, $id) {
        $servicio = Servicio::find($id);
        $user = User::find($request->user()->id);
        if ($servicio->id_cliente != $user->cliente->id) {
            return response()->json(['message' => 'No autorizado'],403);
        }
        while (true) {
            $servicio = Servicio::find($id);
            if ($servicio->precio_final != null) {
                return response()->json(true);
            }
            sleep(1);
        }
        return response()->json(false);
    }

    public function finalizarServicio(Request $request, $id){
        $servicio = Servicio::find($id);
        $user = User::find($request->user()->id);
        if ($servicio->estado != 'pagado') {
            return response()->json(['message' => 'No es posible realizar esta accion ahora.'],400);
        }
        if ($servicio->id_chofer != $user->chofer->id) {
            return response()->json(['message' => 'No autorizado.'],403);
        }
        $servicio->estado = 'finalizado';
        $servicio->save();
        return response()->json(['message' => 'Servicio finalizado.']);
    }

    public function isFinalizable(Request $request, $id) {
        $servicio = Servicio::find($id);
        $user = User::find($request->user()->id);
        if ($servicio->id_cliente != $user->cliente->id) {
            return response()->json(['message' => 'No autorizado.'],403);
        }
        if ($servicio->estado != 'finalizado') {
            return response()->json(false,400);
        }
        else {
            return response()->json(true);
        }
    }

    public function pilotoDescribirVehiculo(Request $request, $id){
        $servicio = Servicio::find($id);
        $user = User::find($request->user()->id);
        if ($servicio->id_chofer != $user->chofer->id) {
            return response()->json(['message' => 'No autorizado.'],403);
        }
        $rules = [
            'descripcion_chofer' => 'required',
            'alta_gama' => 'required|boolean'
        ];
        $data = $request->only('descripcion_chofer','alta_gama');
        $validator = Validator::make($data,$rules);
        if ($validator->fails()) {
            return response()->json(['message'=>'Hay errores en tus datos','errors'=>$validator->messages()],422);
        }
        $servicio->descripcion_chofer = $request->descripcion_chofer;
        $servicio->alta_gama = $request->alta_gama;
        $servicio->save();
        return response()->json(['message'=>'Descripcion guarda con exito']);
    }
}
