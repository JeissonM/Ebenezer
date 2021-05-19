<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemcontenidomateria extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'descripcion', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];
    
    public function contenidoitems() {
        return $this->hasMany('App\Contenidoitem');
    }
    
}
