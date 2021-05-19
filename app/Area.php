<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function componentes()
    {
        return $this->hasMany(Componente::class);
    }

    public function materias()
    {
        return $this->hasMany('Materia');
    }

    public function cicloareas()
    {
        return $this->hasMany(Cicloarea::class);
    }

    public function estandars()
    {
        return $this->hasMany(Estandar::class);
    }
}
