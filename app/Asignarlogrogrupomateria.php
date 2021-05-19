<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignarlogrogrupomateria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'logro_id', 'grupo_id', 'grado_id', 'unidad_id', 'jornada_id', 'periodoacademico_id', 'materia_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function personalizarlogros()
    {
        return $this->hasMany(Personalizarlogro::class);
    }

    public function logro()
    {
        return $this->belongsTo(Logro::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class);
    }

    public function jornada()
    {
        return $this->belongsTo(Jornada::class);
    }

    public function periodoacademico()
    {
        return $this->belongsTo(Periodoacademico::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
