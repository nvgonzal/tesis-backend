<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash, Validator;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $credentials = $request->only('nombre', 'email', 'password', 'ap_paterno'
            , 'ap_materno','telefono_fijo','rut', 'celular');

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users'
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
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json(['message'=>'El usuario ha sido creado. Recibiras un correo de confirmacion.']);
    }
}
