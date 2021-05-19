<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fechasprocesosacademico extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fecha_inicio', 'fecha_fin', 'user_change', 'procesosacademico_id', 'periodoacademico_id', 'unidad_id', 'jornada_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function procesosacademico() {
        return $this->belongsTo('App\Procesosacademicos');
    }

    public function periodoacademico() {
        return $this->belongsTo('App\Periodoacademico');
    }

    public function unidad() {
        return $this->belongsTo('App\Unidad');
    }

    public function jornada() {
        return $this->belongsTo('App\Jornada');
    }

}
