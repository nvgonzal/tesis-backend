<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'razon_social',
        'rut',
        'direccion',
        'cuenta_pago'
    ];

    public function servicios(){
        return $this->hasMany('App\Servicio','id_empresa');
    }

    public function gruas(){
        return $this->hasMany('App\Grua','id_empresa');
    }

    public function choferes(){
        return $this->hasMany('App\Chofer','id_empresa');
    }
}
