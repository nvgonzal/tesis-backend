<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{

    protected $fillable = [
        'nombre',
        'razon_social',
        'rut',
        'direccion',
        'cuenta_pago'
    ];

    public function servicios(){
        return $this->hasMany('App\Servicio');
    }

    public function gruas(){
        return $this->hasMany('App\Grua');
    }
}
