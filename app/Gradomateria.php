<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gradomateria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'peso', 'user_change', 'periodoacademico_id', 'grado_id', 'unidad_id', 'jornada_id', 'materia_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function grupomateriadocentes()
    {
        return $this->hasMany('App\Grupomateriadocente');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function periodoacademico()
    {
        return $this->belongsTo('App\Periodoacademico');
    }

    public function jornada()
    {
        return $this->belongsTo('App\Jornada');
    }

    public function materia()
    {
        return $this->belongsTo('App\Materia');
    }
}
