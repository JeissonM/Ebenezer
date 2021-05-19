<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estandar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'descripcion', 'user_id', 'area_id', 'grado_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function ctunidadestandars()
    {
        return $this->hasMany(Ctunidadestandar::class);
    }

    public function estandarcomponentes()
    {
        return $this->hasMany(Estandarcomponente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }
}
