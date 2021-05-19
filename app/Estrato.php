<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estrato extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'etiqueta', 'descripcion', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function aspirantes()
    {
        return $this->hasMany('App\Aspirante');
    }

    public function estudiantes()
    {
        return $this->hasMany('App\Estudiante');
    }

}
