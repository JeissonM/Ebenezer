<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forodiscusionrespuesta extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'id', 'contenido', 'user_change', 'user_id', 'forodiscusion_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function forodiscusion()
    {
        return $this->belongsTo('App\Forodiscusion');
    }
}
