<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenidoitem extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'contenido', 'itemcontenidomateria_id', 'materia_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function materia() {
        return $this->belongsTo('App\Materia');
    }

    public function itemcontenidomateria() {
        return $this->belongsTo('App\Itemcontenidomateria');
    }

}
