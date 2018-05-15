<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = "clientes";


    protected $fillable = [

        'cuenta_pagos',
        'id_user'
    ];
}
