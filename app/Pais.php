<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'codigo', 'nombre', 'continente', 'region', 'area', 'independencia', 'poblacion', 'expectativa_vida', 'producto_interno_bruto', 'producto_interno_bruto_antiguo', 'nombre_local', 'gobierno', 'jefe_estado', 'capital', 'codigo_dos', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function estados() {
        return $this->hasMany('App\Estado');
    }

    public function personas() {
        return $this->hasMany('App\Persona');
    }

    public function personanaturals() {
        return $this->hasMany('App\Personanatural');
    }

}
