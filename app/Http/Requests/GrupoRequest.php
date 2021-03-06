<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
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
            'nombre' => 'required|max:50',
            'cupo' => 'required',
            'grado_id' => 'required',
            'jornada_id' => 'required',
            'unidad_id' => 'required',
            'periodoacademico_id' => 'required'
        ];
    }
}
