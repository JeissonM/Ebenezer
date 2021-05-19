<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'competencia', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function componentecompetencias()
    {
        return $this->hasMany(Componentecompetencia::class);
    }
}
