<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ciclo', 'descripcion', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function cicloareas()
    {
        return $this->hasMany(Cicloarea::class);
    }

    public function ciclogrados()
    {
        return $this->hasMany(Ciclogrado::class);
    }
}
