<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
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
}
