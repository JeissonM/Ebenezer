<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ceremonia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'lugar', 'user_change', 'fechahorainicio', 'fechahorafin', 'grado_id', 'unidad_id', 'jornada_id', 'periodoacademico_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class);
    }

    public function jornada()
    {
        return $this->belongsTo(Jornada::class);
    }

    public function periodoacademico()
    {
        return $this->belongsTo(Periodoacademico::class);
    }

    public function ceremoniaestudiantes()
    {
        return $this->hasMany(Ceremoniaestudiante::class);
    }
}
