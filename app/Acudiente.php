<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acudiente extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'aspirante_id', 'personanatural_id', 'user_change', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function personanatural() {
        return $this->belongsTo('App\Personanatural');
    }

    public function aspirante() {
        return $this->belongsTo('App\Aspirante');
    }

}
