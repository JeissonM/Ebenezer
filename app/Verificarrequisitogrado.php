<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verificarrequisitogrado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_change', 'estudiante_id', 'asignarrequisitogrado_id', 'periodoacademico_id', 'created_at', 'updated_at'
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

    public function asignarrequisitogrado()
    {
        return $this->belongsTo(Asignarrequisitogrado::class);
    }

    public function peridoacademico()
    {
        return $this->belongsTo(Periodoacademico::class);
    }
}
