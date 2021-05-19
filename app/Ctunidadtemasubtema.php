<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctunidadtemasubtema extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'desarrollo', 'user_id', 'ctunidadtema_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function ctunidadtema()
    {
        return $this->belongsTo(Ctunidadtema::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
