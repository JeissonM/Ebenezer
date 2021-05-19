<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sistemaevaluacion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'nota_inicial', 'nota_final', 'nota_aprobatoria', 'estado', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
    public function evaluacionacademicas()
    {
        return $this->hasMany('App\Evaluacionacademica');
    }
}
