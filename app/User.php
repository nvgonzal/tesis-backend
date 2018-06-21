<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'nombre_completo',
        'celular',
        'telefono_fijo',
        'tipo_usuario',
        'rut',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cliente(){
        return $this->hasOne('App\Cliente','id_user');
    }

    public function chofer(){
        return $this->hasOne('App\Chofer','id_user');
    }
}
