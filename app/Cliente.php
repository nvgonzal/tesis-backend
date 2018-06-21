<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

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
