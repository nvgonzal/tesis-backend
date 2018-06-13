<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grua extends Model
{
    protected $fillable = [
        'patente',
        'tipo',
        'marca',
        'modelo',
        'id_empresa'
    ];

    public function servicios(){
        return $this->hasMany('App\Servicio');
    }

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }
}
