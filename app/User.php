<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'identificacion', 'nombres', 'apellidos', 'email', 'email_verified_at', 'password', 'estado', 'user_change', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ctunidads() {
        return $this->hasMany(Ctunidad::class);
    }

    public function ctunidadtemas() {
        return $this->hasMany(Ctunidadtema::class);
    }

    public function estandars() {
        return $this->hasMany(Estandar::class);
    }

    public function actividads() {
        return $this->hasMany('App\Actividad');
    }

    public function grupousuarios() {
        return $this->belongsToMany('App\Grupousuario');
    }

    public function forodiscusionrespuestas() {
        return $this->hasMany('App\Forodiscusionrespuesta');
    }

    public function forodiscusions() {
        return $this->hasMany('App\Forodiscusion');
    }

    public function preguntas() {
        return $this->hasMany('App\Pregunta');
    }

    public function logros() {
        return $this->hasMany(Logro::class);
    }

    public function ctunidadtemasubtemas() {
        return $this->hasMany(Ctunidadtemasubtema::class);
    }

    public function ctunidadevaluacions() {
        return $this->hasMany(Ctunidadevaluacion::class);
    }
}
