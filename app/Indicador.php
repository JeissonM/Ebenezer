<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'indicador', 'aprendizaje_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function aprendizaje()
    {
        return $this->belongsTo(Aprendizaje::class);
    }
}
