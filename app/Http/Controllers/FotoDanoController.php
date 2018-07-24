<?php

namespace App\Http\Controllers;

use App\FotoDaño;
use App\Servicio;
use App\User;
use Illuminate\Http\Request;
use Gate,Validator,Storage;
use Illuminate\Validation\ValidationException;

class FotoDanoController extends Controller
{
    public function uploadPhoto(Request $request,$id){
        $service = Servicio::find($id);
        $user = User::find($request->user()->id);

        if ($service->id_piloto == $user->chofer->id){

            $rules = [
                'descripcion'   => 'required',
                'foto'          => 'image|dimensions:max_width=1200,max_height=1200'
            ];

            try {
                $validator = Validator::make($request, $rules);
            } catch (ValidationException $e) {
                return response()->json(['message'=>'Hay errores en tus datos','errors'=>$e->errors()]);
            }
            if ($validator->fails()){
                return response()->json(['message'=>'Hay errores en tus datos','errors'=>$validator->messages()]);
            }

            $photo = $request->file('foto');
            $url = 'niru_'.md5(time()).'.'.$photo->getClientOriginalExtension();

            Storage::disk('s3')->put('damage-photo/'.$url,$photo);

            $damagePhoto = new FotoDaño();

            $damagePhoto->url           = env('d2llruesx10ck5.cloudfront.net').'/'.$url;
            $damagePhoto->descripcion   = $request->descripcion;
            $damagePhoto->id_servicio   = $id;
            $damagePhoto->save();

            return response()->json(['message'=>'Foto guardada con exito'],201);
        }
        return response('Operacion no permitida',403);
    }
}
