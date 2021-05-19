<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParametrizardocanexoRequest extends FormRequest
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
            'documentoanexo_id' => 'required',
            'grado_id' => 'required',
            'unidad_id' => 'required',
            'jornada_id' => 'required',
            'procesosacademico_id' => 'required'
        ];
    }
}
