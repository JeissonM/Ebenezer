<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'user_change', 'cupo', 'cupousado', 'periodoacademico_id', 'grado_id', 'unidad_id', 'jornada_id', 'docente_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function periodoacademico()
    {
        return $this->belongsTo('App\Periodoacademico');
    }

    public function jornada()
    {
        return $this->belongsTo('App\Jornada');
    }

    public function docente()
    {
        return $this->belongsTo('App\Docente');
    }

    public function estudiantegrupos()
    {
        return $this->hasMany('App\Estudiantegrupo');
    }

    public function grupomateriadocentes()
    {
        return $this->hasMany('App\Grupomateriadocente');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function asignaractividads()
    {
        return $this->hasMany(Asignaractividad::class);
    }

    public function asignarlogrogrupomaterias()
    {
        return $this->hasMany(Asignarlogrogrupomateria::class);
    }
}
