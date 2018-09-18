<?php

namespace App\Http\Controllers;

use App\Chofer;
use App\Mail\ConfirmacionRegistroChofer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\User;
use Mail;

class ChoferController extends Controller
{
    public function index(Request $request){
        $idUser = $request->user()->id;
        $user = User::find($idUser);

        $choferes = $user->chofer->empresa->choferes;

        $data = new Collection();
        foreach ($choferes as $chofer){
            $data = $data->add(User::find($chofer->id_user));
        }

        return response()->json($data->toArray());
    }

    public function createChofer(Request $request){
        $idUser = $request->user()->id;
        $user = User::find($idUser);

        $empresaId = $user->chofer->empresa->id;

        $random_password = str_random(10);
        try {
            $user = AuthController::createUser($request,'chofer',$random_password);
        } catch (ValidationException $e) {
            return response()->json(['message'=> 'Hay errores en los campos de formulario', 'error'=> $e->validator->messages(), 'trace' => $e->getTrace()],400);
        }
        $chofer = new Chofer();
        $chofer->id_empresa = $empresaId;
        $chofer->id_user = $user->id;
        $chofer->save();

        Mail::to($user->email)->send(new ConfirmacionRegistroChofer($user,$random_password));

        return response()->json(['message'=>'Chofer ha sido ingresado a la base de datos'],201);
    }

    public function delete(Request $request, $id){
        $requestUser = User::find($request->user()->id);
        $chofer = User::find($id);
        $user = $chofer->chofer;
        if (!$chofer->tipo_usuario = 'chofer' || $requestUser->chofer->empresa->id != $chofer->chofer->empresa->id ){
            return response()->json(['message' => 'No es posible borrar esa cuenta'],403);
        }
        $chofer->delete();
        $user->delete();
        return response()->json(['message'=>'Usuario eliminado satisfactoriamente']);
    }
}
