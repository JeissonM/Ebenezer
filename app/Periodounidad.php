<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodounidad extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_change', 'unidad_id', 'periodoacademico_id', 'jornada_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function unidad() {
        return $this->belongsTo('App\Unidad');
    }

    public function periodoacademico() {
        return $this->belongsTo('App\Periodoacademico');
    }

    public function jornada() {
        return $this->belongsTo('App\Jornada');
    }

    public function agendacitas() {
        return $this->hasMany('App\Agendacitas');
    }

}
