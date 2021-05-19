<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personalizarlogro extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'descripcion', 'asignarlogrogrupomateria_id', 'estudiante_id', 'created_at', 'updated_at'
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
        return $this->belongsTo(Estudiante::class);
    }

    public function asignarlogrogrupomateria()
    {
        return $this->belongsTo(Asignarlogrogrupomateria::class);
    }
}
