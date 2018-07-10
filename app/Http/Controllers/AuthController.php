<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Mail\RegisterConfirmation;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Hash, Validator, Mail;
use App\User;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){

        try {
            $user = AuthController::createUser($request, 'cliente');
        } catch (ValidationException $e) {
            return response()->json(['message'=> 'Hay errores en los campos de formulario', 'error'=> $e->validator->messages()],400);
        }

        $client = new Cliente();
        $client->id_user = $user->id;
        $client->save();

        Mail::to($user->email)->send(new RegisterConfirmation($user));

        return response()->json(['message'=>'El usuario ha sido creado. Recibiras un correo de confirmacion.']);
    }

    public function login(Request $request){
        $data = $request->only(['email','password']);
        $rules = [
            'email'     => 'required',
            'password'  => 'required',
        ];

        $validator = Validator::make($data,$rules);
        if ($validator->fails()){
            return response()->json(['message'=>'Hay errores en los campos del formulario','error'=>$validator->messages()]);
        }
        $data = LoginProxy::attemptLogin($data['email'],$data['password']);
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @param $tipo_usuario
     * @param string $random_password
     * @return User
     * @throws ValidationException cuando existen errores de validacion en los campos de request
     */
    public static function createUser(Request $request, $tipo_usuario,$random_password = ""){

        $keys = collect(['nombre', 'email', 'password', 'ap_paterno'
            ,'ap_materno','telefono_fijo','rut', 'celular']);

        $rules = collect([
            'nombre'        => 'required|max:255',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:6',
            'ap_paterno'    => 'required',
            'ap_materno'    => 'required',
            'telefono_fijo' => 'required',
            'celular'       => 'required|min:8',
            'rut'           => 'required|cl_rut',

        ]);

        if (!empty($random_password)){
            $keys->except('password');
            $rules->except('password');
        }

        $data = $request->only($keys->toArray());

        $validator = Validator::make($data, $rules->toArray());
        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = new User();
        $user->nombre           = $request->nombre;
        $user->ap_paterno       = $request->ap_paterno;
        $user->ap_materno       = $request->ap_materno;
        $user->nombre_completo  = $request->nombre .' '. $request->ap_paterno .' '. $request->ap_materno;
        $user->celular          = $request->celular;
        $user->telefono_fijo    = $request->telefono_fijo;
        $user->rut              = $request->rut;
        $user->email            = $request->email;
        $user->tipo_usuario     = $tipo_usuario;

        if (!empty($random_password)){
            $user->password = Hash::make($random_password);
        }
        else {
            $user->password = Hash::make($request->password);
        }


        $user->save();

        return $user;
    }

}
