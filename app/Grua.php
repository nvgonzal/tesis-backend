<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grua extends Model
{

    protected $table = "grua";

    protected $fillable = [
        'patente',
        'tipo',
        'marca',
        'modelo',
        'id_empresa'
    ];
}
