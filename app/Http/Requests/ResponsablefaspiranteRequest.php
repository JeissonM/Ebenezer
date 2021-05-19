<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponsablefaspiranteRequest extends FormRequest
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
            'tipodoc_id' => 'required',
            'primer_nombre' => 'max:50|required',
            'primer_apellido' => 'max:50|required',
            'direccion_trabajo' => 'required',
            'telefono_trabajo' => 'required'
        ];
    }
}
