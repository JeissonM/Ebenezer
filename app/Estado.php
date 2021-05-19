<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'codigo_dane', 'pais_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function pais() {
        return $this->belongsTo('App\Pais');
    }

    public function ciudades() {
        return $this->hasMany('App\Ciudad');
    }
    
    public function personas() {
        return $this->hasMany('App\Persona');
    }
    
    public function personanaturals() {
        return $this->hasMany('App\Personanatural');
    }

}
