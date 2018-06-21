<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grua extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patente',
        'tipo',
        'marca',
        'modelo',
        'id_empresa'
    ];

    public function servicios(){
        return $this->hasMany('App\Servicio','id_grua');
    }

    public function empresa(){
        return $this->belongsTo('App\Empresa','id_empresa');
    }
}
