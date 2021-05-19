<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{


    //devuelve un color
    public function color($index)
    {
        $colors = [
            0 => 'bg-teal',
            1 => 'bg-navy',
            2 => 'bg-olive',
            3 => 'bg-lime',
            4 => 'bg-orange',
            5 => 'bg-fuchsia',
            6 => 'bg-purple',
            7 => 'bg-maroon',
            8 => 'bg-gray',
            9 => 'bg-black',
            10 => 'bg-red',
            11 => 'bg-yellow',
            12 => 'bg-aqua',
            13 => 'bg-blue',
            14 => 'bg-green'
        ];
        return $colors[$index];
    }

    //indice maximo de color
    public function maximo()
    {
        return 14;
    }
}
