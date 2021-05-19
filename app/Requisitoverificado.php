<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisitoverificado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'aspirante_id', 'documentoanexo_id', 'procesosacademico_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function aspirante()
    {
        return $this->belongsTo('App\Aspirante');
    }

    public function procesosacademico()
    {
        return $this->belongsTo('App\Procesosacademico');
    }

    public function documentoanexo()
    {
        return $this->belongsTo('App\Documentoanexo');
    }
}
