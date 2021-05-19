<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciclogrado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'ciclo_id', 'grado_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function grado()
    {
        return $this->BelongsTo(Grado::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }
}
