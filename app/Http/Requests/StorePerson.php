<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerson extends FormRequest
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
            'first_surname' => 'required',
            'name'          => 'required',
            'id_number'     => 'required|unique:person_documents',
            'document_type' => 'required|exists:document_types,id',
        ];
    }
}
