<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoDaño extends Model
{
    protected $table = 'foto_daños';

    public function servicio(){
        return $this->belongsTo('App\Servicio','id_servicio');
    }
}
