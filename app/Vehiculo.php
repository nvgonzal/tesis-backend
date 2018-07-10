<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    public function servicios(){
        return $this->hasMany('App\Servicio','id_vehiculo');
    }

    public function cliente(){
        return $this->belongsTo('App\Cliente','id_cliente');
    }
}
