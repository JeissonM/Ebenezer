<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resactividadresp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'puntos_obtenidos', 'estado', 'tipo', 'respuesta', 'respuesta_id', 'pregunta_id', 'resultadoactividad_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function resultadoactividad()
    {
        return $this->belongsTo(Resultadoactividad::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class);
    }
}
