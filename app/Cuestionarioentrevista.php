<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuestionarioentrevista extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'user_change', 'estado', 'circunscripcion_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function circunscripcion()
    {
        return $this->belongsTo('App\Circunscripcion');
    }

    public function entrevistas()
    {
        return $this->hasMany('App\Entrevista');
    }

    public function cuestionariopreguntas()
    {
        return $this->hasMany('App\Cuestionariopregunta');
    }
}
