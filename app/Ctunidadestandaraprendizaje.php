<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctunidadestandaraprendizaje extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'aprendizaje_id', 'ctunidadestandar_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function aprendizaje() {
        return $this->belongsTo(Aprendizaje::class);
    }

    public function ctunidadestandar() {
        return $this->belongsTo(Ctunidadestandar::class);
    }

    public function ctundestapracts() {
        return $this->hasMany(Ctundestapracts::class);
    }

    public function actividads() {
        return $this->belongsToMany(Actividad::class, 'ctundestapracts');
    }
}
