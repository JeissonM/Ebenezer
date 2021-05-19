<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fecha_ingreso', 'estado', 'barrio_residencia', 'pago', 'grado_anterior', 'periodo_anterior', 'periodoacademico_id', 'grado_id', 'unidad_id', 'estrato_id', 'jornada_id', 'personanatural_id', 'situacionestudiante_id', 'categoria_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function datoscompestudiante()
    {
        return $this->hasOne('App\Datoscompestudiante');
    }

    public function periodoacademico()
    {
        return $this->belongsTo('App\Periodoacademico');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function estrato()
    {
        return $this->belongsTo('App\Estrato');
    }

    public function jornada()
    {
        return $this->belongsTo('App\Jornada');
    }

    public function personanatural()
    {
        return $this->belongsTo('App\Personanatural');
    }

    public function situacionestudiante()
    {
        return $this->belongsTo('App\Situacionestudiante');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }

    public function acudienteestudiantes()
    {
        return $this->hasMany('App\Acudienteestudiante');
    }

    public function padresestudiantes()
    {
        return $this->hasMany('App\Padresestudiante');
    }

    public function resposablefestudiante()
    {
        return $this->hasOne('App\Resposablefestudiante');
    }

    public function personalizarlogros()
    {
        return $this->hasMany(Personalizarlogro::class);
    }

    public function estudiantegrupos()
    {
        return $this->hasMany('App\Estudiantegrupo');
    }

    public function sancions()
    {
        return $this->hasMany(Sancion::class);
    }

    public function verificarrequisitogrados()
    {
        return $this->hasMany(Verificarrequisitogrado::class);
    }

    public function resultadoactividads()
    {
        return $this->hasMany(Resultadoactividad::class);
    }

    public function ceremoniaestudiantes()
    {
        return $this->hasMany(Ceremoniaestudiante::class);
    }
}
