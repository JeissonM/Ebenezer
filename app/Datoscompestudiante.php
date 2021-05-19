<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datoscompestudiante extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'padres_separados', 'iglesia_asiste', 'pastor', 'discapacidad', 'familias_en_accion', 'poblacion_victima_conflicto', 'desplazado', 'colegio_procedencia', 'compromiso_adquirido', 'user_change', 'etnia_id', 'conquienvive_id', 'rangosisben_id', 'entidadsalud_id', 'situacionanioanterior_id', 'estudiante_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function etnia()
    {
        return $this->belongsTo('App\Etnia');
    }

    public function conquienvive()
    {
        return $this->belongsTo('App\Conquienvive');
    }

    public function rangosisben()
    {
        return $this->belongsTo('App\Rangosisben');
    }

    public function entidadsalud()
    {
        return $this->belongsTo('App\Entidadsalud');
    }

    public function situacionanioanterior()
    {
        return $this->belongsTo('App\Situacionanioanterior');
    }

    public function estudiante()
    {
        return $this->belongsTo('App\Estudiante');
    }
}
