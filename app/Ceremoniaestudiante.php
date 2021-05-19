<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Ceremoniaestudiante extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_change', 'estudiante_id', 'ceremonia_id', 'created_at', 'updated_at'
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

    public function ceremonia()
    {
        return $this->belongsTo(Ceremonia::class);
    }
}
