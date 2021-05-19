<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriaRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|unique:materias|max:200|min:3',
            'codigomateria' => 'required|unique:materias|max:30|min:3',
            //'descripcion' => 'max:200|min:3',
            //            'recuperable' => 'required|in:SI,NO',
            //            'nivelable' => 'required|in:SI,NO'
        ];
    }
}
