<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Situacionadministrativa extends Model
{
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

    public function docentes()
    {
        return $this->hasMany('App\Docente');
    }
}
