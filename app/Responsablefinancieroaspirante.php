<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsablefinancieroaspirante extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'direccion_trabajo', 'telefono_trabajo', 'puesto_trabajo', 'empresa_labora', 'jefe_inmediato', 'telefono_jefe', 'descripcion_trabajador_independiente', 'ocupacion_id', 'personanatural_id', 'aspirante_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function ocupacion()
    {
        return $this->belongsTo('App\Ocupacion');
    }

    public function personanatural()
    {
        return $this->belongsTo('App\Personanatural');
    }

    public function aspirante()
    {
        return $this->belongsTo('App\Aspirante');
    }
    
}
