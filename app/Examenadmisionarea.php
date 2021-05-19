<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examenadmisionarea extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'calificacion', 'user_change', 'areaexamenadmisiongrado_id', 'examenadmision_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function areaexamenadmisiongrado()
    {
        return $this->belongsTo('App\Areaexamenadmisiongrado');
    }

    public function examenadmision()
    {
        return $this->belongsTo('App\Examenadmision');
    }
}
