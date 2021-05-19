<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'pregunta', 'puntos', 'tipo', 'respuesta_id', 'user_change', 'user_id', 'grado_id', 'materia_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function respuestas()
    {
        return $this->hasMany('App\Respuesta');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function materia()
    {
        return $this->belongsTo('App\Materia');
    }

    public function actividadpreguntas()
    {
        return $this->belongsTo('App\Actividadpregunta');
    }

    public function resactividadresps()
    {
        return $this->hasMany(Resactividadresp::class);
    }
}
