<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choferes extends Model
{

    protected $fillable = [
        'id_empresa',
        'id_user'
    ];
}
