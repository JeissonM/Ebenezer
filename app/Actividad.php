<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'recurso', 'tipo', 'ebeduc', 'user_change', 'user_id', 'evaluacionacademica_id', 'grado_id', 'materia_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function evaluacionacademica()
    {
        return $this->belongsTo('App\Evaluacionacademica');
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
        return $this->hasMany('App\Actividadpregunta');
    }

    public function asignaractividads()
    {
        return $this->hasMany(Asignaractividad::class);
    }
}
