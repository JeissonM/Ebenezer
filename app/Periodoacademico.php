<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodoacademico extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'etiqueta', 'anio', 'fecha_inicio', 'fecha_fin', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function gradomaterias()
    {
        return $this->hasMany('App\Gradomateria');
    }

    public function grupos()
    {
        return $this->hasMany('App\Grupo');
    }

    public function periodounidad()
    {
        return $this->hasMany('App\Periodounidad');
    }

    public function fechasprocesosacademicos()
    {
        return $this->hasMany('App\Fechasprocesosacademico');
    }

    public function convocatorias()
    {
        return $this->hasMany('App\Convocatoria');
    }

    public function aspirantes()
    {
        return $this->hasMany('App\Aspirante');
    }

    public function estudiantes()
    {
        return $this->hasMany('App\Estudiante');
    }

    public function asignaractividads()
    {
        return $this->hasMany(Asignaractividad::class);
    }

    public function verificarrequisitogrados()
    {
        return $this->hasMany(Verificarrequisitogrado::class);
    }

    public function resultadoactividads()
    {
        return $this->hasMany(Resultadoactividad::class);
    }

    public function ceremonias()
    {
        return $this->hasMany(Ceremonia::class);
    }

    public function asignarlogrogrupomaterias()
    {
        return $this->hasMany(Asignarlogrogrupomateria::class);
    }

}
