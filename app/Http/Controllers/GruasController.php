<?php

namespace App\Http\Controllers;

use App\Grua;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Empresa;
use App\Chofer;


class GruasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->user()->id);
        $grua = $user->chofer->empresa->gruas;
        return response()->json($grua);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
            $grua = new Grua();
            $grua->patente = $request->patente;
            $grua->tipo = $request->tipo;
            $grua->marca = $request->marca;
            $grua->modelo = $request->modelo;
            $grua->id_empresa = $request->id_empresa;
            $grua->save();

            $mensaje = ['message' => 'Grua' . $grua->modelo.' creada', 'data' => $grua];
            return response()->json($mensaje, 201);

        }catch(Exception $e){
            $mensaje = ['mensaje' => 'Error al crear grua'];
            return response()->json($mensaje,500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grua = Grua::find($id);

        if(!$grua) {
            return response()->json(['error' => ['message' => 'no se ha encontrado grua']], 404);
        }
        return response()->json($grua,200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{

            $grua = Grua::findOrFail($id);
            $grua->patente = $request->patente;
            $grua->tipo = $request->tipo;
            $grua->marca = $request->marca;
            $grua->modelo = $request->modelo;
            $grua->id_empresa = $request->id_empresa;
            $grua->save();

            $mensaje = ['message' => 'Grua ' . $grua->modelo .' editada', 'data' => $grua];
            return response()->json($mensaje, 201);

        }catch (Exception $e){
            $mensaje = ['mensaje' => 'Error al actualizar grua'];
            return response()->json($mensaje,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grua = Grua::findOrFail($id);
        $grua->delete();
        $mensaje = ['message' => 'Grua Patente' . $grua->patente . ' ha sido Eliminada', 'data' => $grua];
        return response()->json($mensaje,201);
    }
}
