<?php

namespace App\Http\Controllers;

use App\Empresa;
use http\Env\Response;
use Illuminate\Http\Request;

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
        return response()->json($empresa,200);
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
            $empresa = new Empresa();
            $empresa->nombre = $request->nombre;
            $empresa->razon_social = $request->razon_social;
            $empresa->rut = $request->rut;
            $empresa->direccion = $request->direccion;
            $empresa->cuenta_pago = $request->cuenta_pago;
            $empresa->save();

            $mensaje = ['message' => 'Empresa' . $empresa->nombre.' creado', 'data' => $empresa];
            return response()->json($mensaje, 201);


        }
        catch (Exception $e){
            $mensaje = ['mensaje' => 'Error al crear objeto'];
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
        $empresa = Empresa::find($id);

        if(!$empresa){
            return response()->json(['error'=>['message'=> 'no se ha encontrado la empresa']],404);
        }

        return response()->json($empresa,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


            $empresa = Empresa::findOrFail($id);
            $empresa->nombre = $request->input('nombre');
            $empresa->razon_social = $request->razon_social;
            $empresa->rut = $request->rut;
            $empresa->direccion = $request->direccion;
            $empresa->cuenta_pago = $request->cuenta_pago;

            $empresa->save();

            $message = ['message' => 'Empresa' . $empresa->nombre . ' actualizado','data'=> $empresa ];

            return response()->json($message,201);
        }catch (Exception $e){
            $mensaje = ['mensaje' => 'Error al actualizar objeto'];
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
        $empresa = Empresa::find($id);
        $empresa->delete();

        $mensaje = ['message'=> 'Empresa' . $empresa->nombre .'Borrada', 'data'=>$empresa];
        return response()->json($mensaje,201);
    }
}
