<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctunidadevaluacion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'evaluacionacademica_id', 'ctunidad_id', 'user_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function evaluacionacademica()
    {
        return $this->belongsTo(Evaluacionacademica::class);
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
