<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forodiscusion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titulo', 'contenido', 'user_change', 'user_id', 'grupomateriadocente_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function forodiscusionrespuestas()
    {
        return $this->hasMany('App\Forodiscusionrespuesta');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function grupomateriadocente()
    {
        return $this->belongsTo('App\Grupomateriadocente');
    }
}
