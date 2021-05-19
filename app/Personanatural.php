<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personanatural extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'primer_nombre', 'segundo_nombre', 'fecha_nacimiento', 'libreta_militar', 'edad', 'rh', 'primer_apellido', 'segundo_apellido', 'distrito_militar', 'numero_pasaporte', 'otra_nacionalidad', 'clase_libreta', 'fax', 'ocupacion', 'profesion', 'nivel_estudio', 'user_change', 'ciudad_id', 'estado_id', 'pais_id', 'persona_id', 'sexo_id', 'created_at', 'updated_at'
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
        return $this->hasOne('App\Estudiante');
    }

    public function pais()
    {
        return $this->belongsTo('App\Pais');
    }

    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    public function ciudad()
    {
        return $this->belongsTo('App\Ciudad');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

    public function sexo()
    {
        return $this->belongsTo('App\Sexo');
    }

    public function acudientes()
    {
        return $this->hasMany('App\Acudiente');
    }

    public function responsablefinancieroaspirantes()
    {
        return $this->hasMany('App\Responsablefinancieroaspirante');
    }

    public function acudienteestudiantes()
    {
        return $this->hasMany('App\Acudienteestudiante');
    }

    public function resposablefestudiantes()
    {
        return $this->hasMany('App\Resposablefestudiante');
    }

    public function docente()
    {
        return $this->hasOne('App\Docente');
    }
}
