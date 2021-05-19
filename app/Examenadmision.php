<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examenadmision extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'calificacion', 'anotaciones', 'soporte', 'user_change', 'estado', 'aspirante_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function aspirante()
    {
        return $this->belongsTo('App\Aspirante');
    }

    public function examenadmisionareas()
    {
        return $this->hasMany('App\Examenadmisionarea');
    }
}
