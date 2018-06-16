<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{

    protected $fillable = [
        'id_empresa',
        'id_user'
    ];
}
