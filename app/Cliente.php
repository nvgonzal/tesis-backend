<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{


    protected $fillable = [
        'cuenta_pagos',
        'id_user'
    ];
}
