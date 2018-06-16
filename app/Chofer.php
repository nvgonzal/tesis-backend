<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{

    protected $table = 'choferes';

    protected $fillable = [
        'id_empresa',
        'id_user'
    ];

    public function usuario(){
        return $this->belongsTo('App\User','id_user');
    }

    public function servicios(){
        return $this->hasMany('App\Servicio','id_chofer');
    }
}
