<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FotoDaño extends Model
{
    use SoftDeletes;

    protected $table = 'foto_daños';

    public function servicio(){
        return $this->belongsTo('App\Servicio','id_servicio');
    }
}
