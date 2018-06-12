<?php

namespace App\Http\Controllers;

use App\Mail\RegisterConfirmation;
use Illuminate\Http\Request;
use Hash, Validator, Mail;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $credentials = $request->only('nombre', 'email', 'password', 'ap_paterno'
            , 'ap_materno','telefono_fijo','rut', 'celular');

        $rules = [
            'nombre'          => 'required|max:255',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:6',
            'ap_paterno'    => 'required',
            'ap_materno'    => 'required',
            'telefono_fijo' => 'required',
            'celular'       => 'required|min:8',
            'rut'           => 'required|cl_rut',
        ];
        $validator = Validator::make($credentials, $rules);
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
        $user->tipo_usuario = 'cliente';
        $user->password = Hash::make($request->password);

        $user->save();

        Mail::to($user->email)->send(new RegisterConfirmation($user));

        return response()->json(['message'=>'El usuario ha sido creado. Recibiras un correo de confirmacion.']);
    }
}
