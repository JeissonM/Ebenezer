<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AspiranteRequest extends FormRequest
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
            'numero_documento' => 'required|max:15',
            'primer_nombre' => 'required|max:50',
            'primer_apellido' => 'required|max:50',
            'tipodoc_id' => 'required',
            'periodoacademico_id' => 'required',
            'grado_id' => 'required',
            'unidad_id' => 'required',
            'estrato_id' => 'required',
            'jornada_id' => 'required',
            'circunscripcion_id' => 'required',
            'situacionanioanterior_id' => 'required'
        ];
    }
}
