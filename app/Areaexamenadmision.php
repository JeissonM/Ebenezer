<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areaexamenadmision extends Model
{
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

    public function areaexamenadmisiongrados()
    {
        return $this->hasMany('App\Areaexamenadmisiongrado');
    }
}
