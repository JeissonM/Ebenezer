<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendacitas extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fecha', 'horainicio', 'horafin', 'estado', 'periodounidad_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function periodounidad() {
        return $this->belongsTo('App\Periodounidad');
    }

    public function entrevista()
    {
        return $this->hasOne('App\Entrevista');
    }

}
