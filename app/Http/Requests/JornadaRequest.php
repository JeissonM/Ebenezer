<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JornadaRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'descripcion' => 'required|max:50',
            'horainicio' => 'max:5',
            'horafin' => 'max:5',
            'jornadasnies' => 'max:8',
            'findesemana' => 'max:2'
        ];
    }

}
