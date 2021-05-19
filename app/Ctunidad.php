<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctunidad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'resumen', 'como_desarrollar', 'cuando_desarrollar', 'donde_desarrollar', 'grado_id', 'user_id', 'materia_id', 'created_at', 'updated_at'
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

    public function ctunidadtemas()
    {
        return $this->hasMany(Ctunidadtema::class);
    }

    public function ctunidadestandars()
    {
        return $this->hasMany(Ctunidadestandar::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
