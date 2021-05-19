<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuestionariopregunta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'pregunta', 'tipo', 'estado', 'segunda_pregunta', 'user_change', 'cuestionarioentrevista_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function entrevistapreres()
    {
        return $this->hasMany('App\Entrevistapreres');
    }

    public function cuestionarioentrevista()
    {
        return $this->belongsTo('App\Cuestionarioentrevista');
    }

    public function cuestionarioprespuestas()
    {
        return $this->hasMany('App\Cuestionarioprespuesta');
    }
}
