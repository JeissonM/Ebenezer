<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aprendizaje extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'logro', 'logro_negativo', 'componentecompetencia_id', 'estandarcomponente_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function indicadors()
    {
        return $this->hasMany(Indicador::class);
    }

    public function componentecompetencia()
    {
        return $this->belongsTo(Componentecompetencia::class);
    }

    public function estandarcomponente()
    {
        return $this->belongsTo(Estandarcomponente::class);
    }
}
