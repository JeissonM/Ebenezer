<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tipopersona', 'direccion', 'mail', 'celular', 'telefono', 'numero_documento', 'lugar_expedicion', 'fecha_expedicion', 'nombrecomercial', 'regimen', 'user_change', 'tipodoc_id', 'pais_id', 'estado_id', 'ciudad_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function tipodoc() {
        return $this->belongsTo('App\Tipodoc');
    }

    public function pais() {
        return $this->belongsTo('App\Pais');
    }

    public function estado() {
        return $this->belongsTo('App\Estado');
    }

    public function ciudad() {
        return $this->belongsTo('App\Ciudad');
    }

    public function personanatural() {
        return $this->hasOne('App\Personanatural');
    }

}
