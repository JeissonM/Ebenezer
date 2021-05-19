<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Padresestudiante extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'numero_documento', 'lugar_expedicion', 'fecha_expedicion', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'vive', 'acudiente', 'direccion_residencia', 'barrio_residencia', 'telefono', 'celular', 'correo', 'padre_madre', 'sexo_id', 'tipodoc_id', 'ocupacion_id', 'estudiante_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function sexo()
    {
        return $this->belongsTo('App\Sexo');
    }

    public function tipodoc()
    {
        return $this->belongsTo('App\Tipodoc');
    }

    public function ocupacion()
    {
        return $this->belongsTo('App\Ocupacion');
    }

    public function estudiante()
    {
        return $this->belongsTo('App\Estudiante');
    }
}
