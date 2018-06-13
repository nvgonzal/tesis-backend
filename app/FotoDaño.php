<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoDaño extends Model
{
    public function servicio(){
        return $this->belongsTo('App\Servicio');
    }
}
