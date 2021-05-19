<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'codigo', 'descripcion', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function resposablefestudiantes()
    {
        return $this->hasMany('App\Resposablefestudiante');
    }

    public function padresestudiantes()
    {
        return $this->hasMany('App\Padresestudiante');
    }

    public function padresaspirantes()
    {
        return $this->hasMany('App\Padresaspirante');
    }

    public function responsablefinancieroaspirantes(){
        return $this->hasMany('App\Responsablefinancieroaspirante');
    }

}
