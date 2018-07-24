<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Empresa;

class BuscarGruaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        //$empresas = Empresa::all();

        $latitud = -36.827348;
        $longitud = -73.050255;
        $radius = 1;
        $listaEmpresas = array();


        $empresa = Empresa::select('*')->selectRaw('( 6371 * acos( cos( radians(?) ) *
                               cos( radians( latitud) )
                               * cos( radians( longitud) - radians(?)
                               ) + sin( radians(?) ) *
                               sin( radians( latitud ) ) )
                             ) AS distance', [$latitud, $longitud, $latitud])
            ->havingRaw("distance < ?", [$radius])
            ->get();



       return response()->json($empresa);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Returns Bases near User
     *
     * @param float $latitud
     * @param float $longitud
     * @param integer $distancia
     *
     * @return \Illuminate\Http\Response
     */
    public function harvesine (Request $request)
    {

        $user = User::findOrFail($request->user()->id);

        //$latitud = -36.827348;
        //$longitud = -73.050255;

        $latitud = $request->latitud;
        $longitud = $request->longitud;
        $distancia = 9;

        $empresa = Empresa::select('*')->selectRaw('( 6371 * acos( cos( radians(?) ) *
                               cos( radians( latitud) )
                               * cos( radians( longitud) - radians(?)
                               ) + sin( radians(?) ) *
                               sin( radians( latitud ) ) )
                             ) AS distance', [$latitud, $longitud, $latitud])
            ->havingRaw("distance < ?", [$distancia])
            ->get();



        return response()->json($empresa);
    }

}
