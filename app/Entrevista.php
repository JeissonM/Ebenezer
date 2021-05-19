<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrevista extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'estado', 'anotaciones', 'user_change', 'agendacita_id', 'cuestionarioentrevista_id', 'aspirante_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function aspirante()
    {
        return $this->belongsTo('App\Aspirante');
    }

    public function agendacita()
    {
        return $this->belongsTo('App\Agendacitas');
    }

    public function cuestionarioentrevista()
    {
        return $this->belongsTo('App\Cuestionarioentrevista');
    }

    public function entrevistapreres()
    {
        return $this->hasMany('App\Entrevistapreres');
    }
}
