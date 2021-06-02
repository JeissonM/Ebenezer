<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctundestapracts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'actividad_id', 'ctunidadestandaraprendizaje_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function actividad() {
        return $this->belongsTo(Actividad::class);
    }

    public function ctunidadestandaraprendizaje() {
        return $this->belongsTo(Ctunidadestandaraprendizaje::class);
    }

}
