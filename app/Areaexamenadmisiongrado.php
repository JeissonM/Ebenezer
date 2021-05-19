<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areaexamenadmisiongrado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'peso', 'areaexamenadmision_id', 'grado_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function areaexamenadmision()
    {
        return $this->belongsTo('App\Areaexamenadmision');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function examenadmisionareas()
    {
        return $this->hasMany('App\Examenadmisionarea');
    }
}
