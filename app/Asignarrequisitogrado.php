<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignarrequisitogrado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_change', 'requisito_id', 'grado_id', 'unidad_id', 'jornada_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function requisitogrado()
    {
        return $this->belongsTo(Requisitogrado::class);
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

    public function verificarrequisitogrados()
    {
        return $this->hasMany(Verificarrequisitogrado::class);
    }
}
