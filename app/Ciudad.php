<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'codigo_dane', 'estado_dpto', 'codigo_pais', 'distrito', 'poblacion', 'estado_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function estado() {
        return $this->belongsTo('App\Estado');
    }

    public function unidads() {
        return $this->hasMany('App\Unidad');
    }
    
    public function personas() {
        return $this->hasMany('App\Persona');
    }
    
    public function personanaturals() {
        return $this->hasMany('App\Personanatural');
    }

    public function aspirantes()
    {
        return $this->hasMany('App\Aspirante');
    }

}
