<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sancion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'sancion', 'fechainicio', 'fechafin', 'estado', 'user_change', 'estudiante_id', 'created_at', 'updated_at'
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
}
