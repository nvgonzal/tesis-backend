<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{


    protected $fillable = [

        'cuenta_pagos',
        'id_user'
    ];
}
