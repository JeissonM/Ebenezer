<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'descripcion', 'grado_id', 'unidad_id', 'jornada_id', 'materia_id', 'user_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

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

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asignarlogrogrupomaterias()
    {
        return $this->hasMany(Asignarlogrogrupomateria::class);
    }
}
