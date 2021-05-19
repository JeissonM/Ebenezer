<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluacionacademica extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'peso', 'user_change', 'sistemaevaluacion_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function ctunidadevaluacions()
    {
        return $this->hasMany(Ctunidadevaluacion::class);
    }

    public function actividads()
    {
        return $this->hasMany('App\Actividad');
    }

    public function sistemaevaluacion()
    {
        return $this->belongsTo('App\Sistemaevaluacion');
    }

    public function asignaractividads()
    {
        return $this->hasMany(Asignaractividad::class);
    }

    public function resultadoactividads()
    {
        return $this->hasMany(Resultadoactividad::class);
    }
}
