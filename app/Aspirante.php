<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aspirante extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'foto', 'numero_documento', 'lugar_expedicion', 'fecha_expedicion', 'rh', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'fecha_nacimiento', 'telefono', 'celular', 'correo', 'direccion_residencia', 'barrio_residencia', 'user_change', 'estado', 'tipodoc_id', 'sexo_id', 'ciudad_id', 'periodoacademico_id', 'grado_id', 'unidad_id', 'estrato_id', 'jornada_id', 'convocatoria_id', 'circunscripcion_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function acudientes()
    {
        return $this->hasMany('App\Acudiente');
    }

    public function tipodoc()
    {
        return $this->belongsTo('App\Tipodoc');
    }

    public function sexo()
    {
        return $this->belongsTo('App\Sexo');
    }

    public function circunscripcion()
    {
        return $this->belongsTo('App\Circunscripcion');
    }

    public function convocatoria()
    {
        return $this->belongsTo('App\Convocatoria');
    }

    public function jornada()
    {
        return $this->belongsTo('App\Jornada');
    }

    public function estrato()
    {
        return $this->belongsTo('App\Estrato');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function ciudad()
    {
        return $this->belongsTo('App\Ciudad');
    }

    public function periodoacademico()
    {
        return $this->belongsTo('App\Periodoacademico');
    }

    public function datoscomplementariosaspirante()
    {
        return $this->hasOne('App\Datoscomplementariosaspirante');
    }

    public function padresaspirantes()
    {
        return $this->hasMany('App\Padresaspirante');
    }

    public function responsablefinancieroaspirante()
    {
        return $this->hasOne('App\Responsablefinancieroaspirante');
    }

    public function entrevista()
    {
        return $this->hasOne('App\Entrevista');
    }

    public function requisitoverificados()
    {
        return $this->hasMany('App\Requisitoverificado');
    }

    public function examenadmision()
    {
        return $this->hasOne('App\Examenadmision');
    }
}
