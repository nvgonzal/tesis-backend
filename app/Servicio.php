<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;

    public function grua(){
        return $this->belongsTo('App\Grua','id_grua');
    }

    public function empresa(){
        return $this->belongsTo('App\Empresa','id_empresa');
    }

    public function cliente(){
        return $this->belongsTo('App\Cliente','id_cliente');
    }

    public function chofer(){
        return $this->belongsTo('App\Chofer','id_chofer');
    }

    public function fotos_daños(){
        return $this->hasMany('App\FotoDaño','id_servicio');
    }

    public function vehiculo(){
        return $this->belongsTo('App\Vehiculo','id_vehiculo');
    }
}
