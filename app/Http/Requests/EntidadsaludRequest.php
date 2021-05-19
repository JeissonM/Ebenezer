<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntidadsaludRequest extends FormRequest {

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
            'codigo' => 'required|max:100',
            'nombre' => 'required|max:100',
            'tipoentidad' => 'required|max:30',
            'sector' => 'max:30',
            'acronimo' => 'max:50',
            'estado' => 'max:10'
        ];
    }

}
