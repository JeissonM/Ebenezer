<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignaractividad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fecha_inicio', 'fecha_final', 'ebeduc', 'peso', 'periodoacademico_id', 'evaluacionacademica_id', 'grupo_id', 'actividad_id', 'created_at', 'updated_at'
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
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    public function resultadoactividads()
    {
        return $this->hasMany(Resultadoactividad::class);
    }
}
