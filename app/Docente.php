<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_change', 'personanatural_id', 'situacionadministrativa_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function personanatural()
    {
        return $this->belongsTo('App\Personanatural');
    }

    public function grupomateriadocentes()
    {
        return $this->hasMany('App\Grupomateriadocente');
    }

    public function grupo()
    {
        return $this->hasOne('App\Grupo');
    }

    public function situacionadministrativa()
    {
        return $this->belongsTo('App\Situacionadministrativa');
    }
}
