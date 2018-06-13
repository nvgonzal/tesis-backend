<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    public function grua(){
        return $this->belongsTo('App\Grua');
    }

    public function fotos_daños(){
        return $this->hasMany('App\FotoDaño');
    }

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }
}
