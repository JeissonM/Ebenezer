<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctunidadestandar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'estandar_id', 'ctunidad_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function estandar()
    {
        return $this->belongsTo(Estandar::class);
    }

    public function ctunidadestandaraprendizajes()
    {
        return $this->hasMany(Ctunidadestandaraprendizaje::class);
    }

    public function ctunidad()
    {
        return $this->belongsTo(Ctunidad::class);
    }
}
