<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'descripcion', 'horainicio', 'horafin', 'jornadasnies', 'findesemana', 'user_change' . 'created_at', 'updated_at'
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

    public function estudiantes()
    {
        return $this->hasMany('App\Estudiante');
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

    public function parametrizardocumentoanexos()
    {
        return $this->hasMany('App\Parametrizardocumentoanexo');
    }

    public function aspirantes()
    {
        return $this->hasMany('App\Aspirante');
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
