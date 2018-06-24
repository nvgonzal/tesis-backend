<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Mail\RegisterConfirmation;
use Illuminate\Http\Request;
use Hash, Validator, Mail;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request){

        $user = $this->createUser($request,'cliente');

        $client = new Cliente();
        $client->id_user = $user->id;
        $client->save();

        Mail::to($user->email)->send(new RegisterConfirmation($user));

        return response()->json(['message'=>'El usuario ha sido creado. Recibiras un correo de confirmacion.']);
    }

    public static function createUser(Request $request, $tipo_usuario,$random_password = ''){

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

        if (isset($random_password)){
            $keys->except('password');
            $rules->except('password');
        }

        $data = $request->only($keys->toArray());

        $validator = Validator::make($data, $rules->toArray());
        if($validator->fails()) {
            return response()->json(['message'=> 'Hay errores en los campos de formulario', 'error'=> $validator->messages()]);
        }

        $user = new User();
        $user->nombre = $request->nombre;
        $user->ap_paterno = $request->ap_paterno;
        $user->ap_materno = $request->ap_materno;
        $user->nombre_completo = $request->nombre .' '. $request->ap_paterno .' '. $request->ap_materno;
        $user->celular = $request->celular;
        $user->telefono_fijo = $request->telefono_fijo;
        $user->rut = $request->rut;
        $user->email = $request->email;
        $user->tipo_usuario = $tipo_usuario;

        if (isset($random_password)){
            $user->password = Hash::make($random_password);
        }
        else {
            $user->password = Hash::make($request->password);
        }


        $user->save();

        return $user;
    }

}
