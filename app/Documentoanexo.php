<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentoanexo extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];
    
    public function parametrizardocumentoanexos(){
        return $this->hasMany('App\Parametrizardocumentoanexo');
    }

    public function requisitoverificados()
    {
        return $this->hasMany('App\Requisitoverificado');
    }

}
