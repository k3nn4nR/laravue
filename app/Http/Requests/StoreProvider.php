<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProvider extends FormRequest
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
            'company'   => 'required',
            'acronym'   => 'required|unique:companies',
            'document_type_id'  => 'required|exists:document_types,id',
            'id_number' => 'required|unique:person_documents',
        ];
    }
}
