<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametrizardocumentoanexo extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'documentoanexo_id', 'grado_id', 'unidad_id', 'jornada_id', 'procesosacademico_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function documentoanexo()
    {
        return $this->belongsTo('App\Documentoanexo');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function jornada()
    {
        return $this->belongsTo('App\Jornada');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function procesosacademico(){
        return $this->belongsTo('App\Procesosacademico');
    }
}
