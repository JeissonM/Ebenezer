<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model {

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

    public function grupousuarios() {
        return $this->belongsToMany('App\Grupousuarios');
    }

}
