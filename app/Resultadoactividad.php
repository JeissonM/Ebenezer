<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultadoactividad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'calificacion', 'anotaciones_sistema', 'anotaciones_docente', 'recurso', 'ebeduc', 'peso', 'tipo', 'periodoacademico_id', 'evaluacionacademica_id', 'grupo_id', 'asignaractividad_id', 'estudiante_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function periodoacademico()
    {
        return $this->belongsTo(Periodoacademico::class);
    }

    public function evaluacionacademica()
    {
        return $this->belongsTo(Evaluacionacademica::class);
    }

    public function asignaractividad()
    {
        return $this->belongsTo(Asignaractividad::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function resactividadresps()
    {
        return $this->hasMany(Resactividadresp::class);
    }
}
