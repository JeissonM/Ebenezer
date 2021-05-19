<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estandarcomponente extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'componente_id', 'estandar_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function ctunidadestandaraprendizajes()
    {
        return $this->hasMany(Ctunidadestandaraprendizaje::class);
    }

    public function aprendizajes()
    {
        return $this->hasMany(Aprendizaje::class);
    }

    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }

    public function estandar()
    {
        return $this->belongsTo(Estandar::class);
    }
}
