<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'componente', 'descripcion', 'area_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function estandarcomponentes()
    {
        return $this->hasMany(Estandarcomponente::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function componentecompetencias()
    {
        return $this->hasMany(Componentecompetencia::class);
    }
}
