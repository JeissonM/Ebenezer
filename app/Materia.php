<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'codigomateria', 'nombre', 'descripcion', 'ih', 'recuperable', 'nivelable', 'area_id', 'naturaleza_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function ctunidads()
    {
        return $this->hasMany(Ctunidad::class);
    }

    public function preguntas()
    {
        return $this->hasMany('App\Pregunta');
    }

    public function actividads()
    {
        return $this->hasMany('App\Actividad');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function naturaleza()
    {
        return $this->belongsTo('App\Naturaleza');
    }

    public function contenidoitems()
    {
        return $this->hasMany('App\Contenidoitem');
    }

    public function gradomaterias()
    {
        return $this->hasMany('App\Gradomateria');
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
