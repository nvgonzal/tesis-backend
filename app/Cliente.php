<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $fillable = [
        'cuenta_pagos',
        'id_user'
    ];

    public function usuario(){
        return $this->belongsTo('App\User','id_user');
    }

    public function servicios(){
        return $this->hasMany('App\Servicio','id_cliente');
    }
}
