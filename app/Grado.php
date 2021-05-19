<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{

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

    public function estandars()
    {
        return $this->hasMany(Estandar::class);
    }

    public function ctunidads()
    {
        return $this->hasMany(Ctunidad::class);
    }

    public function ciclogrados()
    {
        return $this->hasMany(Ciclogrado::class);
    }

    public function preguntas()
    {
        return $this->hasMany('App\Pregunta');
    }

    public function actividads()
    {
        return $this->hasMany('App\Actividad');
    }

    public function gradomaterias()
    {
        return $this->hasMany('App\Gradomateria');
    }

    public function convocatorias()
    {
        return $this->hasMany('App\Convocatoria');
    }

    public function parametrizardocumentoanexos()
    {
        return $this->hasMany('App\Parametrizardocumentoanexo');
    }

    public function aspirantes()
    {
        return $this->hasMany('App\Aspirante');
    }

    public function areaexamenadmisiongrados()
    {
        return $this->hasMany('App\Areaexamenadmisiongrado');
    }

    public function estudiantes()
    {
        return $this->hasMany('App\Estudiante');
    }

    public function grupos()
    {
        return $this->hasMany('App\Grupo');
    }

    public function resultadoactividads()
    {
        return $this->hasMany(Resultadoactividad::class);
    }

    public function asignarrequisitogrados()
    {
        return $this->hasMany(Asignarrequisitogrado::class);
    }

    public function ceremonias()
    {
        return $this->hasMany(Ceremonia::class);
    }

    public function logros()
    {
        return $this->hasMany(Logro::class);
    }

    public function asignarlogrogrupomaterias()
    {
        return $this->hasMany(Asignarlogrogrupomateria::class);
    }
}
