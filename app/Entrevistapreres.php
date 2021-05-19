<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrevistapreres extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'respuesta', 'tipo', 'user_change', 'cuestionariopregunta_id', 'cuestionarioprespuesta_id', 'entrevista_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function cuestionariopregunta()
    {
        return $this->belongsTo('App\Cuestionariopregunta');
    }

    public function cuestionarioprespuesta()
    {
        return $this->belongsTo('App\Cuestionarioprespuesta');
    }

    public function entrevista()
    {
        return $this->belongsTo('App\Entrevista');
    }
}
