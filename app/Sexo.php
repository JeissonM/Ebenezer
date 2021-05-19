<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'abreviatura', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function padresestudiantes()
    {
        return $this->hasMany('App\Padresestudiante');
    }

    public function personanaturals() {
        return $this->hasMany('App\Personanatural');
    }

    public function aspirantes()
    {
        return $this->hasMany('App\Aspirante');
    }

    public function padresaspirantes()
    {
        return $this->hasMany('App\Padresaspirante');
    }

}
