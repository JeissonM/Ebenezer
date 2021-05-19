<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupousuario extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function paginas() {
        return $this->belongsToMany('App\Pagina');
    }

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function modulos() {
        return $this->belongsToMany('App\Modulo');
    }

}
