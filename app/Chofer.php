<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chofer extends Model
{
    use SoftDeletes;

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
