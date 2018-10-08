<?php

namespace App\Http\Controllers;

use App\Chofer;
use App\Empresa;
use Illuminate\Http\Request;
use App\Mail\userEmpresaCreate;
use Illuminate\Validation\ValidationException;
use GuzzleHttp\Exception\ClientException;
use Mail, Validator;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa = Empresa::all();
        return response()->json($empresa, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre_empresa'    => 'required',
            'razon_social'      => 'required',
            'rut_empresa'       => 'required',
            'direccion'         => 'required',
            'cuenta_pago'       => 'required|email',
            'nombre'            => 'required|max:255',
            'email'             => 'required|email|max:255|unique:users',
            'apellido_paterno'  => 'required',
            'apellido_materno'  => 'required',
            'telefono_fijo'     => 'required',
            'celular'           => 'required|min:8',
            'rut'               => 'required|cl_rut',
        ];

        $validator = Validator::make($request->toArray(),$rules);

        if ($validator->fails()){
            return response(['message'=>'Hay errores en tus entradas','error'=>$validator->messages()],400);
        }
        $client = new \GuzzleHttp\Client();
        $direccion = str_replace(' ','+',$request->direccion);
        $api_key = env('GOOGLE_MAPS_API_KEY');
        try {
            $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json?address='.$direccion.'&key='.$api_key);
        }
        catch (ClientException $e) {
            return response()->json(['message' => 'Error al obtener coordenadas.']);
        }
        $response = \GuzzleHttp\json_decode($response->getBody());
        $responseBody = json_decode(json_encode($response),true);
        switch ($responseBody['status']) {
            case 'ZERO_RESULTS':
                return response()->json(['message' => 'Direccion invalida para obtener coordenadas'],421);
                break;
            case 'OK':
                $latitud = $responseBody['results'][0]['geometry']['location']['lat'];
                $longitud = $responseBody['results'][0]['geometry']['location']['lng'];
                break;
        }

        $random_pass = str_random(8);
        try {
            $usuario = AuthController::createUser($request, 'dueño', $random_pass);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Hay errores en tus entradas.','error' => $e->validator->messages()],400);
        }

        try {
            $empresa = new Empresa();
            $empresa->nombre = $request->nombre_empresa;
            $empresa->razon_social = $request->razon_social;
            $empresa->rut = $request->rut_empresa;
            $empresa->direccion = $request->direccion;
            $empresa->cuenta_pago = $request->cuenta_pago;
            $empresa->latitud = $latitud;
            $empresa->longitud = $longitud;
            $empresa->save();


            $chofer = new Chofer();
            $chofer->id_user = $usuario->id;
            $chofer->id_empresa = $empresa->id;
            $chofer->save();

            $mensaje = ['message' => 'Empresa registrada con exito'];
            Mail::to($usuario->email)->send(new userEmpresaCreate($usuario, $random_pass));

            return response()->json($mensaje, 201);
        }
        catch (Exception $e){
            $mensaje = ['mensaje' => 'Error al crear Empresa'];
            return response()->json($mensaje,500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = Empresa::find($id);
        if (!$empresa) {
            return response()->json(['error' => ['message' => 'no se ha encontrado la empresa']], 404);
        }
        return response()->json($empresa, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'nombre_empresa'    => 'required',
                'razon_social'      => 'required',
                'rut_empresa'       => 'required',
                'direccion'         => 'required',
                'cuenta_pago'       => 'required|email',
            ];

            $validator = Validator::make($request->toArray(),$rules);

            if ($validator->fails()){
                return response(['message'=>'Hay errores en tus entradas','error'=>$validator->messages()],400);
            }
            $empresa = Empresa::findOrFail($id);
            $empresa->nombre = $request->nombre_empresa;
            $empresa->razon_social = $request->razon_social;
            $empresa->rut = $request->rut_empresa;
            $empresa->direccion = $request->direccion;
            $empresa->cuenta_pago = $request->cuenta_pago;
            $empresa->save();

            $message = ['message' => 'Empresa ' . $empresa->nombre . ' actualizado'];

            return response()->json($message, 200);
        } catch (Exception $e) {
            $mensaje = ['mensaje' => 'Error al actualizar empresa'];
            return response()->json($mensaje, 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $empresa->delete();

        $mensaje = ['message' => 'Empresa' . $empresa->nombre . 'Borrada'];
        return response()->json($mensaje, 201);
    }
}
