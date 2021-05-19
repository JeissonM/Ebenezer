<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rangonota extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'valor_inicial', 'valor_final', 'valor_cualitativo', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
}
