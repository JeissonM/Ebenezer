<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupomateriadocente extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_change', 'gradomateria_id', 'docente_id', 'grupo_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function gradomateria()
    {
        return $this->belongsTo('App\Gradomateria');
    }

    public function grupo()
    {
        return $this->belongsTo('App\Grupo');
    }

    public function docente()
    {
        return $this->belongsTo('App\Docente');
    }

    public function forodiscusions()
    {
        return $this->hasMany('App\Forodiscusion');
    }
}
