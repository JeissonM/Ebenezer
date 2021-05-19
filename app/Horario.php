<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'horario', 'user_change', 'grupo_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
