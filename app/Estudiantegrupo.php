<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiantegrupo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'estudiante_id', 'grupo_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function estudiante()
    {
        return $this->belongsTo('App\Estudiante');
    }

    public function grupo()
    {
        return $this->belongsTo('App\Grupo');
    }
}
