<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctunidadtema extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'introduccion', 'duracion', 'user_id', 'ctunidad_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function ctunidadtemasubtemas()
    {
        return $this->hasMany(Ctunidadtemasubtema::class);
    }

    public function ctunidad()
    {
        return $this->belongsTo(Ctunidad::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
