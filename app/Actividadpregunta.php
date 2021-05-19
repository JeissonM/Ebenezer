<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividadpregunta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'actividad_id', 'pregunta_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function actividad()
    {
        return $this->belongsTo('App\Actividad');
    }

    public function pregunta()
    {
        return $this->belongsTo('App\Pregunta');
    }
}
