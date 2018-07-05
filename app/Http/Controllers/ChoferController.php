<?php

namespace App\Http\Controllers;

use App\Chofer;
use App\Mail\ConfirmacionRegistroChofer;
use Illuminate\Http\Request;
use App\User;
use Mail;

class ChoferController extends Controller
{
    public function index(Request $request){
        $idUser = $request->user()->id;
        $user = User::find($idUser);

        $choferes = $user->chofer->empresa->choferes;

        return response()->json($choferes);
    }

    public function createChofer(Request $request){
        $idUser = $request->user()->id;
        $user = User::find($idUser);

        $empresaId = $user->chofer->empresa->id;

        $random_password = str_random(10);
        $user = AuthController::createUser($request,'chofer',$random_password);

        $chofer = new Chofer();
        $chofer->id_empresa = $empresaId;
        $chofer->id_user = $user->id;
        $chofer->save();

        Mail::to($user->email)->send(new ConfirmacionRegistroChofer($user,$random_password));

        return response()->json(['message'=>'Chofer ha sido ingresado a la base de datos'],201);
    }

    public function delete(Request $request, $id){
        $requestUser = User::find($request->user()->id);
        $chofer = Chofer::find($id);
        $user = $chofer->usuario;
        if (!$user->tipo_usuario = 'chofer' || $requestUser->chofer->empresa->id != $chofer->empresa->id ){
            return response()->json(['message' => 'No es posible borrar esa cuenta'],403);
        }
        $chofer->delete();
        $user->delete();
        return response()->json(['message'=>'Usuario eliminado satisfactoriamente']);
    }
}
