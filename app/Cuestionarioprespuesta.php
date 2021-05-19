<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuestionarioprespuesta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'respuesta', 'user_change', 'cuestionariopregunta_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function entrevistapreres()
    {
        return $this->hasMany('App\Entrevistapreres');
    }

    public function cuestionariopregunta()
    {
        return $this->belongsTo('App\Cuestionariopregunta');
    }
}
