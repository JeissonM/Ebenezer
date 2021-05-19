<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidadsalud extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'codigo', 'nombre', 'tipoentidad', 'sector', 'acronimo', 'estado', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function datoscomplementariosaspirantes()
    {
        return $this->hasMany('App\Datoscomplementariosaspirante');
    }

    public function datoscompestudiantes()
    {
        return $this->hasMany('App\Datoscompestudiante');
    }

}
