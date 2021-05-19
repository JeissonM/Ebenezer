<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'respuesta', 'letra', 'pregunta_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function pregunta()
    {
        return $this->belongsTo('App\Pregunta');
    }

    public function resactividadresps()
    {
        return $this->hasMany(Resactividadresp::class);
    }
}
